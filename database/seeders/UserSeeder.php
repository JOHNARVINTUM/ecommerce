<?php

namespace Database\Seeders;

use App\Models\ProviderProfile;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::updateOrCreate(
            ['email' => 'limax.feu@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        UserProfile::updateOrCreate(
            ['user_id' => $admin->id],
            [
                'full_name' => 'Admin User',
                'phone' => '09000000001',
                'location' => 'Manila, Philippines',
                'bio' => 'System administrator for LIMAX.',
            ]
        );

        UserSetting::updateOrCreate(
            ['user_id' => $admin->id],
            [
                'language' => 'en',
                'theme' => 'light',
                'notifications_enabled' => true,
            ]
        );

        // Providers
        $providers = [
            [
                'name' => 'John Dev',
                'email' => 'provider1@limax.test',
                'full_name' => 'John Dev',
                'display_name' => 'John Dev Studio',
                'headline' => 'Laravel Developer and Web Specialist',
                'bio' => 'I build custom Laravel apps, dashboards, and business websites.',
                'country' => 'Philippines',
                'languages' => 'English, Filipino',
                'response_time' => '1 hour',
                'last_delivery_note' => 'Delivered 3 web app projects this month.',
                'github_url' => 'https://github.com/johndev',
            ],
            [
                'name' => 'Mia Design',
                'email' => 'provider2@limax.test',
                'full_name' => 'Mia Design',
                'display_name' => 'Mia Creative',
                'headline' => 'Brand Designer and UI Specialist',
                'bio' => 'I create logos, product branding, and beautiful user interfaces.',
                'country' => 'Philippines',
                'languages' => 'English',
                'response_time' => '2 hours',
                'last_delivery_note' => 'Completed multiple branding packages recently.',
                'github_url' => null,
            ],
            [
                'name' => 'Alex Edit',
                'email' => 'provider3@limax.test',
                'full_name' => 'Alex Edit',
                'display_name' => 'Alex Media Works',
                'headline' => 'Video Editor and Content Producer',
                'bio' => 'I edit reels, ads, tutorials, and professional content for creators.',
                'country' => 'Philippines',
                'languages' => 'English',
                'response_time' => '3 hours',
                'last_delivery_note' => 'Delivered short-form and promo video packages.',
                'github_url' => null,
            ],
        ];

        foreach ($providers as $providerData) {
            $provider = User::updateOrCreate(
                ['email' => $providerData['email']],
                [
                    'name' => $providerData['name'],
                    'password' => Hash::make('password'),
                    'role' => 'provider',
                ]
            );

            UserProfile::updateOrCreate(
                ['user_id' => $provider->id],
                [
                    'full_name' => $providerData['full_name'],
                    'phone' => '09170000000',
                    'location' => $providerData['country'],
                    'bio' => $providerData['bio'],
                ]
            );

            UserSetting::updateOrCreate(
                ['user_id' => $provider->id],
                [
                    'language' => 'en',
                    'theme' => 'light',
                    'notifications_enabled' => true,
                ]
            );

            ProviderProfile::updateOrCreate(
                ['user_id' => $provider->id],
                [
                    'display_name' => $providerData['display_name'],
                    'headline' => $providerData['headline'],
                    'bio' => $providerData['bio'],
                    'country' => $providerData['country'],
                    'languages' => $providerData['languages'],
                    'response_time' => $providerData['response_time'],
                    'last_delivery_note' => $providerData['last_delivery_note'],
                    'member_since' => now()->subMonths(rand(3, 18))->toDateString(),
                    'avatar_path' => null,
                    'github_url' => $providerData['github_url'],
                ]
            );
        }

        // Customers
        $customers = [
            ['name' => 'Customer One', 'email' => 'customer1@limax.test'],
            ['name' => 'Customer Two', 'email' => 'customer2@limax.test'],
            ['name' => 'Customer Three', 'email' => 'customer3@limax.test'],
            ['name' => 'Customer Four', 'email' => 'customer4@limax.test'],
            ['name' => 'Customer Five', 'email' => 'customer5@limax.test'],
        ];

        foreach ($customers as $customerData) {
            $customer = User::updateOrCreate(
                ['email' => $customerData['email']],
                [
                    'name' => $customerData['name'],
                    'password' => Hash::make('password'),
                    'role' => 'customer',
                ]
            );

            // Special handling for customer1@limax.test
            if ($customerData['email'] === 'customer1@limax.test') {
                UserProfile::updateOrCreate(
                    ['user_id' => $customer->id],
                    [
                        'full_name' => $customerData['name'],
                        'phone' => '09123456789',
                        'location' => '598 Guyabano St. Napico Manggahan Pasig City',
                        'bio' => 'LIMAX customer account.',
                    ]
                );
            } else {
                UserProfile::updateOrCreate(
                    ['user_id' => $customer->id],
                    [
                        'full_name' => $customerData['name'],
                        'phone' => '09990000000',
                        'location' => 'Philippines',
                        'bio' => 'LIMAX customer account.',
                    ]
                );
            }

            UserSetting::updateOrCreate(
                ['user_id' => $customer->id],
                [
                    'language' => 'en',
                    'theme' => 'light',
                    'notifications_enabled' => true,
                ]
            );
        }
    }
}