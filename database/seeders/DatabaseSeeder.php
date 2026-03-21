<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ServiceCategorySeeder::class,
            ServiceListingSeeder::class,
            OrderSeeder::class,
            PaymentSeeder::class,
        ]);
    }
}
