<?php

namespace App\Http\Controllers;

use App\Mail\OrderVerificationMail;
use App\Models\Order;
use App\Models\ServiceListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function create(ServiceListing $service)
    {
        if (! auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in first to continue your booking.');
        }

        if (auth()->user()->role !== 'customer') {
            return redirect()->back()->with('error', 'Only customers can place orders.');
        }

        return view('pages.checkout.create', [
            'service' => $service,
            'paymongoCheckoutUrl' => config('services.paymongo.checkout_url'),
        ]);
    }

    public function store(Request $request, ServiceListing $service)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== 'customer') {
            abort(403, 'Only customers can place orders.');
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:255'],
            'customer_address' => ['nullable', 'string'],
            'payment_method' => ['required', 'in:gcash_demo,maya_demo'],
            'billing_name' => ['nullable', 'string', 'max:255'],
            'billing_phone' => ['nullable', 'string', 'max:255'],
            'billing_address' => ['nullable', 'string'],
            'simulate_payment_confirmation' => ['required', 'accepted'],
        ]);

        $paymentMethod = $validated['payment_method'];

        if ($paymentMethod === 'paymongo_checkout_demo') {
            $paymentWasSimulated = true;
            $paymentSummary = 'Payment simulation: PayMongo hosted checkout demo (' . config('services.paymongo.checkout_url') . ')';
        } elseif ($paymentMethod === 'gcash_demo') {
            $paymentWasSimulated = true;
            $paymentSummary = 'Payment simulation: Gcash checkout demo to number 0917-111-2222';
        } else {
            $paymentWasSimulated = true;
            $paymentSummary = 'Payment simulation: Maya checkout demo to number 0918-111-3333';
        }

        $orderNotes = trim(implode("\n\n", array_filter([
            $validated['notes'] ?? null,
            $paymentSummary,
            $validated['billing_name'] ? 'Billing Name: ' . $validated['billing_name'] : null,
            $validated['billing_phone'] ? 'Billing Phone: ' . $validated['billing_phone'] : null,
            $validated['billing_address'] ? 'Billing Address: ' . $validated['billing_address'] : null,
        ])));

        $order = Order::create([
            'customer_user_id' => auth()->id(),
            'provider_user_id' => $service->provider_user_id,
            'service_listing_id' => $service->id,
            'order_number' => 'LIMAX-' . strtoupper(Str::random(10)),
            'amount' => $service->price,
            'currency' => 'PHP',
            'status' => Order::STATUS_PENDING,
            'payment_status' => $paymentWasSimulated ? Order::PAYMENT_PAID : Order::PAYMENT_UNPAID,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'] ?? null,
            'customer_address' => $validated['customer_address'] ?? null,
            'notes' => $orderNotes !== '' ? $orderNotes : null,
        ]);

        try {
            $order->loadMissing('serviceListing');
            Mail::to($order->customer_email)->send(new OrderVerificationMail($order));
        } catch (\Throwable $exception) {
            Log::warning('Order confirmation email failed.', [
                'order_id' => $order->id,
                'email' => $order->customer_email,
                'error' => $exception->getMessage(),
            ]);
        }

        return redirect()
            ->route('orders.show', $order)
            ->with('success', $paymentWasSimulated
                ? 'Your booking has been placed and the PayMongo payment was simulated successfully.'
                : 'Your booking has been placed successfully.');
    }
}
