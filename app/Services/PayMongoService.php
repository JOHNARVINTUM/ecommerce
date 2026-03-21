<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class PayMongoService
{
    public function createCheckoutSession(Order $order, array $urls): array
    {
        $secretKey = (string) config('services.paymongo.secret_key');

        if ($secretKey === '') {
            throw new \RuntimeException('PayMongo secret key is missing.');
        }

        $paymentMethods = config('services.paymongo.payment_methods', ['gcash']);

        if ($paymentMethods === []) {
            $paymentMethods = ['gcash'];
        }

        $eligiblePaymentMethods = $this->getEligiblePaymentMethods($secretKey);

        if ($eligiblePaymentMethods !== []) {
            $filteredPaymentMethods = array_values(array_intersect($paymentMethods, $eligiblePaymentMethods));

            if ($filteredPaymentMethods === []) {
                throw new \RuntimeException(
                    'Requested PayMongo payment methods are not enabled for this account. Enabled methods: '.implode(', ', $eligiblePaymentMethods)
                );
            }

            $paymentMethods = $filteredPaymentMethods;
        }

        $response = Http::withBasicAuth($secretKey, '')
            ->acceptJson()
            ->post($this->endpoint('/checkout_sessions'), [
                'data' => [
                    'attributes' => [
                        'billing' => [
                            'name' => $order->customer_name,
                            'email' => $order->customer_email,
                            'phone' => $order->customer_phone,
                            'address' => [
                                'line1' => $order->customer_address,
                            ],
                        ],
                        'send_email_receipt' => true,
                        'show_description' => true,
                        'show_line_items' => true,
                        'description' => 'Payment for order '.$order->order_number,
                        'line_items' => [[
                            'currency' => $order->currency,
                            'amount' => $this->amountToMinorUnit($order->amount),
                            'name' => $order->serviceListing->title ?? 'Service order',
                            'quantity' => 1,
                        ]],
                        'payment_method_types' => $paymentMethods,
                        'success_url' => $urls['success_url'],
                        'cancel_url' => $urls['cancel_url'],
                        'metadata' => [
                            'order_id' => (string) $order->id,
                            'order_number' => $order->order_number,
                            'customer_email' => $order->customer_email,
                        ],
                        'reference_number' => $order->order_number,
                    ],
                ],
            ]);

        $this->throwIfFailed($response);

        return $response->json('data') ?? [];
    }

    public function createPendingPayment(Order $order, array $checkoutSession): Payment
    {
        $sessionId = data_get($checkoutSession, 'id');
        $checkoutUrl = data_get($checkoutSession, 'attributes.checkout_url');

        return Payment::create([
            'order_id' => $order->id,
            'payer_user_id' => $order->customer_user_id,
            'payee_user_id' => $order->provider_user_id,
            'payment_reference' => $sessionId,
            'amount' => $order->amount,
            'currency' => $order->currency,
            'payment_method' => implode(',', config('services.paymongo.payment_methods', ['gcash'])),
            'status' => Payment::STATUS_PENDING,
            'metadata' => [
                'checkout_session_id' => $sessionId,
                'checkout_url' => $checkoutUrl,
                'paymongo' => $checkoutSession,
            ],
        ]);
    }

    public function markCheckoutSessionPaid(array $payload): ?Payment
    {
        $sessionId = data_get($payload, 'data.attributes.data.id');

        if (! $sessionId) {
            return null;
        }

        $payment = Payment::where('payment_reference', $sessionId)->first();

        if (! $payment) {
            return null;
        }

        $paymentAttributes = data_get($payload, 'data.attributes.data.attributes.payments.0.attributes', []);
        $paymentId = data_get($payload, 'data.attributes.data.attributes.payments.0.id');
        $paidAt = data_get($payload, 'data.attributes.data.attributes.paid_at');

        $payment->forceFill([
            'status' => Payment::STATUS_PAID,
            'paid_at' => $paidAt ? Carbon::createFromTimestamp((int) $paidAt) : now(),
            'payment_method' => data_get($paymentAttributes, 'source.type', $payment->payment_method),
            'metadata' => array_merge($payment->metadata ?? [], [
                'checkout_session_id' => $sessionId,
                'checkout_payment_id' => $paymentId,
                'paymongo_event' => $payload,
            ]),
        ])->save();

        $order = $payment->order;

        if ($order) {
            $order->forceFill([
                'payment_status' => Order::PAYMENT_PAID,
                'status' => $order->status === Order::STATUS_PENDING ? Order::STATUS_CONFIRMED : $order->status,
            ])->save();
        }

        return $payment->fresh();
    }

    public function markPaymentFailed(array $payload): ?Payment
    {
        $paymentId = data_get($payload, 'data.attributes.data.id');

        if (! $paymentId) {
            return null;
        }

        $payment = Payment::query()
            ->where('payment_reference', $paymentId)
            ->orWhere('metadata->checkout_payment_id', $paymentId)
            ->first();

        if (! $payment) {
            return null;
        }

        $payment->forceFill([
            'status' => Payment::STATUS_FAILED,
            'metadata' => array_merge($payment->metadata ?? [], [
                'paymongo_event' => $payload,
            ]),
        ])->save();

        return $payment->fresh();
    }

    public function verifyWebhookSignature(?string $signatureHeader, string $payload): bool
    {
        $secret = (string) config('services.paymongo.webhook_secret');

        if ($secret === '' || $signatureHeader === null || $signatureHeader === '') {
            return false;
        }

        $parts = [];

        foreach (explode(',', $signatureHeader) as $part) {
            [$key, $value] = array_pad(explode('=', trim($part), 2), 2, null);

            if ($key !== null && $value !== null) {
                $parts[$key] = $value;
            }
        }

        $timestamp = $parts['t'] ?? null;
        $providedSignature = str_starts_with((string) config('services.paymongo.secret_key'), 'sk_live_')
            ? ($parts['li'] ?? null)
            : ($parts['te'] ?? null);

        if (! $timestamp || ! $providedSignature) {
            return false;
        }

        $expectedSignature = hash_hmac('sha256', $timestamp.'.'.$payload, $secret);

        return hash_equals($expectedSignature, $providedSignature);
    }

    private function endpoint(string $path): string
    {
        return rtrim((string) config('services.paymongo.base_url'), '/').'/'.ltrim($path, '/');
    }

    private function getEligiblePaymentMethods(string $secretKey): array
    {
        $response = Http::withBasicAuth($secretKey, '')
            ->acceptJson()
            ->get($this->endpoint('/merchants/capabilities/payment_methods'));

        if (! $response->successful()) {
            return [];
        }

        $methods = [];

        foreach ($response->json('data', []) as $method) {
            $status = strtolower((string) data_get($method, 'attributes.status', ''));
            $isEnabled = (bool) data_get($method, 'attributes.enabled', false)
                || (bool) data_get($method, 'attributes.available', false)
                || in_array($status, ['enabled', 'active', 'available'], true);

            if (! $isEnabled) {
                continue;
            }

            $candidates = array_filter([
                strtolower((string) data_get($method, 'id')),
                strtolower((string) data_get($method, 'type')),
                strtolower((string) data_get($method, 'attributes.code')),
                strtolower((string) data_get($method, 'attributes.name')),
                strtolower((string) data_get($method, 'attributes.payment_method_type')),
            ]);

            foreach ($candidates as $candidate) {
                foreach (['gcash', 'maya', 'card', 'grab_pay', 'grabpay', 'shopeepay', 'billease', 'dob', 'qrph'] as $supportedMethod) {
                    if (str_contains($candidate, $supportedMethod)) {
                        $methods[] = $supportedMethod === 'grab_pay' ? 'grabpay' : $supportedMethod;
                    }
                }
            }
        }

        return array_values(array_unique($methods));
    }

    private function amountToMinorUnit(float|string $amount): int
    {
        return (int) round(((float) $amount) * 100);
    }

    private function throwIfFailed(Response $response): void
    {
        if ($response->successful()) {
            return;
        }

        throw new RequestException($response);
    }
}
