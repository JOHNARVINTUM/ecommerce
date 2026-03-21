<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PayMongoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(private readonly PayMongoService $payMongoService)
    {
    }

    public function start(Order $order)
    {
        $user = auth()->user();

        abort_unless($user && $user->role === 'customer', 403);
        abort_unless($order->customer_user_id === $user->id, 403);

        if ($order->payment_status === Order::PAYMENT_PAID) {
            return redirect()
                ->route('orders.show', $order)
                ->with('success', 'This order has already been paid.');
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
            Log::error('Failed to start PayMongo checkout session.', [
                'order_id' => $order->id,
                'error' => $exception->getMessage(),
            ]);

            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'Unable to start PayMongo checkout right now. Please try again.');
        }
    }

    public function success(Request $request)
    {
        $order = $this->resolveOrderFromRequest($request);

        if ($order) {
            return redirect()
                ->route('orders.show', $order)
                ->with('success', 'Payment submitted. We are waiting for PayMongo to confirm it.');
        }

        return redirect()
            ->route('orders.index')
            ->with('success', 'Payment submitted. We are waiting for PayMongo to confirm it.');
    }

    public function failed(Request $request)
    {
        $order = $this->resolveOrderFromRequest($request);

        if ($order) {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'Payment was cancelled or not completed.');
        }

        return redirect()
            ->route('orders.index')
            ->with('error', 'Payment was cancelled or not completed.');
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $signatureHeader = $request->header('Paymongo-Signature');
        $eventType = $request->input('data.attributes.type');

        if ((string) config('services.paymongo.webhook_secret') !== '') {
            $isValid = $this->payMongoService->verifyWebhookSignature($signatureHeader, $payload);

            if (! $isValid) {
                Log::warning('Rejected PayMongo webhook due to invalid signature.');

                return response()->json(['message' => 'Invalid signature.'], 400);
            }
        }

        $decodedPayload = $request->json()->all();

        match ($eventType) {
            'checkout_session.payment.paid' => $this->payMongoService->markCheckoutSessionPaid($decodedPayload),
            'payment.failed' => $this->payMongoService->markPaymentFailed($decodedPayload),
            default => null,
        };

        return response()->json(['received' => true]);
    }

    private function resolveOrderFromRequest(Request $request): ?Order
    {
        $orderId = $request->integer('order');

        if (! $orderId) {
            return null;
        }

        return Order::find($orderId);
    }
}
