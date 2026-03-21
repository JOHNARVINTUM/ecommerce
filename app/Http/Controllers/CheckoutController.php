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
            'scheduled_date' => ['nullable', 'date', 'after_or_equal:today'],
            'scheduled_time' => ['nullable'],
            'notes' => ['nullable', 'string'],
            'payment_method' => ['required', 'in:paymongo_checkout_demo'],
            'simulate_payment_confirmation' => ['required', 'accepted'],
        ]);

        $paymentMethod = $validated['payment_method'];
        $paymentWasSimulated = $paymentMethod === 'paymongo_checkout_demo';
        $paymentSummary = 'Payment simulation: PayMongo hosted checkout demo (' . config('services.paymongo.checkout_url') . ')';
        $orderNotes = trim(implode("\n\n", array_filter([
            $validated['notes'] ?? null,
            $paymentWasSimulated ? $paymentSummary : null,
        ])));

        $order = Order::create([
            'customer_user_id' => auth()->id(),
            'provider_user_id' => $service->provider_user_id,
            'service_listing_id' => $service->id,
            'order_number' => 'LIMAX-' . strtoupper(Str::random(10)),
            'amount' => $service->price,
            'currency' => 'PHP',
            'scheduled_date' => $validated['scheduled_date'] ?? null,
            'scheduled_time' => $validated['scheduled_time'] ?? null,
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
