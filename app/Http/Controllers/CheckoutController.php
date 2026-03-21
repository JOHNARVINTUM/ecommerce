<?php

namespace App\Http\Controllers;

use App\Mail\OrderVerificationMail;
use App\Models\Order;
use App\Models\ServiceListing;
use App\Services\PayMongoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct(private readonly PayMongoService $payMongoService)
    {
    }

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
            'paymongoPaymentMethods' => config('services.paymongo.payment_methods', ['gcash']),
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
        ]);

        $order = Order::create([
            'customer_user_id' => auth()->id(),
            'provider_user_id' => $service->provider_user_id,
            'service_listing_id' => $service->id,
            'order_number' => 'LIMAX-' . strtoupper(Str::random(10)),
            'amount' => $service->price,
            'currency' => 'PHP',
            'status' => Order::STATUS_PENDING,
            'payment_status' => Order::PAYMENT_UNPAID,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'] ?? null,
            'customer_address' => $validated['customer_address'] ?? null,
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

        try {
            $order->loadMissing('serviceListing');

            $checkoutSession = $this->payMongoService->createCheckoutSession($order, [
                'success_url' => route('payments.success', ['order' => $order->id]),
                'cancel_url' => route('payments.failed', ['order' => $order->id]),
            ]);

            $this->payMongoService->createPendingPayment($order, $checkoutSession);

            $checkoutUrl = data_get($checkoutSession, 'attributes.checkout_url');

            if (! $checkoutUrl) {
                throw new \RuntimeException('PayMongo checkout URL was not returned.');
            }

            return redirect()->away($checkoutUrl);
        } catch (\Throwable $exception) {
            Log::error('Failed to create PayMongo checkout during order checkout.', [
                'order_id' => $order->id,
                'service_id' => $service->id,
                'error' => $exception->getMessage(),
            ]);

            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'Order created, but PayMongo checkout could not be started. You can retry payment from the order page.');
        }
    }
}
