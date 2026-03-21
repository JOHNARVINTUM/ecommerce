<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\ServiceListing;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get()->values();
        $listings = ServiceListing::with('provider')->where('is_active', true)->get()->values();

        if ($customers->isEmpty() || $listings->isEmpty()) {
            return;
        }

        $baseDate = Carbon::today();

        foreach ($customers as $customerIndex => $customer) {
            $customerListings = $listings->slice($customerIndex, 2);

            if ($customerListings->isEmpty()) {
                $customerListings = $listings->take(2);
            }

            foreach ($customerListings->values() as $listingIndex => $listing) {
                $status = match (($customerIndex + $listingIndex) % 4) {
                    0 => Order::STATUS_PENDING,
                    1 => Order::STATUS_CONFIRMED,
                    2 => Order::STATUS_IN_PROGRESS,
                    default => Order::STATUS_COMPLETED,
                };

                $paymentStatus = $status === Order::STATUS_COMPLETED
                    ? Order::PAYMENT_PAID
                    : Order::PAYMENT_UNPAID;

                $orderNumber = sprintf('LIMAX-SEED-%04d', ($customerIndex * 10) + $listingIndex + 1);

                Order::updateOrCreate(
                    ['order_number' => $orderNumber],
                    [
                        'customer_user_id' => $customer->id,
                        'provider_user_id' => $listing->provider_user_id,
                        'service_listing_id' => $listing->id,
                        'amount' => $listing->price,
                        'currency' => $listing->currency ?: 'PHP',
                        'scheduled_date' => $baseDate->copy()->addDays($customerIndex + $listingIndex + 1)->toDateString(),
                        'scheduled_time' => '10:00:00',
                        'status' => $status,
                        'payment_status' => $paymentStatus,
                        'customer_name' => $customer->name,
                        'customer_email' => $customer->email,
                        'customer_phone' => '09990000000',
                        'customer_address' => 'Metro Manila, Philippines',
                        'notes' => 'Seeded order for local development.',
                    ]
                );

            }
        }
    }
}
