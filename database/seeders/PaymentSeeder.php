<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::with(['customer', 'provider'])->get();

        foreach ($orders as $order) {
            $paymentStatus = $order->payment_status === Order::PAYMENT_PAID
                ? Payment::STATUS_PAID
                : Payment::STATUS_PENDING;

            Payment::updateOrCreate(
                ['payment_reference' => 'PAY-' . $order->order_number],
                [
                    'order_id' => $order->id,
                    'payer_user_id' => $order->customer_user_id,
                    'payee_user_id' => $order->provider_user_id,
                    'amount' => $order->amount,
                    'currency' => $order->currency,
                    'payment_method' => 'manual',
                    'status' => $paymentStatus,
                    'paid_at' => $paymentStatus === Payment::STATUS_PAID ? now() : null,
                    'metadata' => [
                        'source' => 'database-seeder',
                        'order_number' => $order->order_number,
                    ],
                ]
            );
        }
    }
}
