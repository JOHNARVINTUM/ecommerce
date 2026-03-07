<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use App\Models\ServiceListing;
use App\Models\User;
use Illuminate\Database\Seeder;

class ServiceListingSeeder extends Seeder
{
    public function run(): void
    {
        $providers = User::where('role', 'provider')->get()->values();
        $categories = ServiceCategory::orderBy('sort_order')->get()->keyBy('slug');

        if ($providers->count() < 3 || $categories->isEmpty()) {
            return;
        }

        $listings = [
            [
                'service_category_slug' => 'programming',
                'provider_index' => 0,
                'title' => 'Build a custom Laravel business website',
                'slug' => 'build-custom-laravel-business-website',
                'short_description' => 'Responsive Laravel website tailored to your business goals.',
                'description' => 'I will build a clean and scalable Laravel website with modern UI, contact forms, and business-ready structure.',
                'price' => 14500.00,
                'currency' => 'PHP',
                'sold_count' => 14,
                'rating_avg' => 4.80,
                'rating_count' => 10,
                'delivery_time_days' => 7,
                'revisions' => 2,
                'is_active' => true,
            ],
            [
                'service_category_slug' => 'programming',
                'provider_index' => 0,
                'title' => 'Create a Laravel admin dashboard',
                'slug' => 'create-laravel-admin-dashboard',
                'short_description' => 'Admin panel with charts, tables, and CRUD modules.',
                'description' => 'I will create a custom Laravel admin dashboard for your team with responsive tables, KPIs, and management flows.',
                'price' => 18500.00,
                'currency' => 'PHP',
                'sold_count' => 9,
                'rating_avg' => 4.90,
                'rating_count' => 7,
                'delivery_time_days' => 10,
                'revisions' => 3,
                'is_active' => true,
            ],
            [
                'service_category_slug' => 'web-design',
                'provider_index' => 1,
                'title' => 'Design a modern landing page UI',
                'slug' => 'design-modern-landing-page-ui',
                'short_description' => 'Clean and high-converting landing page design.',
                'description' => 'I will design a modern landing page UI focused on trust, conversion, and a professional user experience.',
                'price' => 7000.00,
                'currency' => 'PHP',
                'sold_count' => 18,
                'rating_avg' => 4.70,
                'rating_count' => 13,
                'delivery_time_days' => 4,
                'revisions' => 2,
                'is_active' => true,
            ],
            [
                'service_category_slug' => 'web-design',
                'provider_index' => 1,
                'title' => 'Design a full website homepage in Figma',
                'slug' => 'design-full-website-homepage-in-figma',
                'short_description' => 'Homepage UI mockup for startups and online businesses.',
                'description' => 'I will create a polished homepage design in Figma with responsive sections and a clear visual hierarchy.',
                'price' => 8500.00,
                'currency' => 'PHP',
                'sold_count' => 11,
                'rating_avg' => 4.60,
                'rating_count' => 8,
                'delivery_time_days' => 5,
                'revisions' => 2,
                'is_active' => true,
            ],
            [
                'service_category_slug' => 'graphic-design',
                'provider_index' => 1,
                'title' => 'Create branded social media graphics',
                'slug' => 'create-branded-social-media-graphics',
                'short_description' => 'Branded visual assets for posts, stories, and promos.',
                'description' => 'I will design consistent and eye-catching social media graphics that match your brand identity.',
                'price' => 5500.00,
                'currency' => 'PHP',
                'sold_count' => 25,
                'rating_avg' => 4.90,
                'rating_count' => 20,
                'delivery_time_days' => 3,
                'revisions' => 3,
                'is_active' => true,
            ],
            [
                'service_category_slug' => 'graphic-design',
                'provider_index' => 1,
                'title' => 'Design a professional brand kit',
                'slug' => 'design-professional-brand-kit',
                'short_description' => 'Logo usage, colors, typography, and brand assets.',
                'description' => 'I will create a professional brand kit to help your business stay visually consistent across platforms.',
                'price' => 10500.00,
                'currency' => 'PHP',
                'sold_count' => 8,
                'rating_avg' => 4.80,
                'rating_count' => 6,
                'delivery_time_days' => 6,
                'revisions' => 2,
                'is_active' => true,
            ],
            [
                'service_category_slug' => 'video-editing',
                'provider_index' => 2,
                'title' => 'Edit short-form reels and TikTok videos',
                'slug' => 'edit-short-form-reels-and-tiktok-videos',
                'short_description' => 'Fast-paced editing for short-form content creators.',
                'description' => 'I will edit engaging reels and short videos with captions, timing, and smooth transitions.',
                'price' => 4500.00,
                'currency' => 'PHP',
                'sold_count' => 30,
                'rating_avg' => 4.90,
                'rating_count' => 24,
                'delivery_time_days' => 2,
                'revisions' => 2,
                'is_active' => true,
            ],
            [
                'service_category_slug' => 'video-editing',
                'provider_index' => 2,
                'title' => 'Produce a polished promo video edit',
                'slug' => 'produce-polished-promo-video-edit',
                'short_description' => 'Professional edit for ads, launches, and marketing content.',
                'description' => 'I will turn your raw footage into a clean promo video with pacing, transitions, text, and music timing.',
                'price' => 140.00,
                'currency' => 'PHP',
                'sold_count' => 12,
                'rating_avg' => 4.70,
                'rating_count' => 9,
                'delivery_time_days' => 4,
                'revisions' => 2,
                'is_active' => true,
            ],
            [
                'service_category_slug' => 'photo-editing',
                'provider_index' => 2,
                'title' => 'Retouch portraits and product photos',
                'slug' => 'retouch-portraits-and-product-photos',
                'short_description' => 'Clean and natural photo enhancement work.',
                'description' => 'I will professionally retouch portraits and product images for cleaner presentation and stronger visual appeal.',
                'price' => 3500.00,
                'currency' => 'PHP',
                'sold_count' => 16,
                'rating_avg' => 4.60,
                'rating_count' => 11,
                'delivery_time_days' => 2,
                'revisions' => 2,
                'is_active' => true,
            ],
            [
                'service_category_slug' => 'logo-making',
                'provider_index' => 1,
                'title' => 'Design a modern business logo',
                'slug' => 'design-modern-business-logo',
                'short_description' => 'Professional logo design for startups and brands.',
                'description' => 'I will design a modern and memorable logo that fits your brand identity and target audience.',
                'price' => 6500.00,
                'currency' => 'PHP',
                'sold_count' => 19,
                'rating_avg' => 4.80,
                'rating_count' => 15,
                'delivery_time_days' => 4,
                'revisions' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($listings as $listing) {
            $category = $categories->get($listing['service_category_slug']);
            $provider = $providers[$listing['provider_index']] ?? null;

            if (! $category || ! $provider) {
                continue;
            }

            ServiceListing::updateOrCreate(
                ['slug' => $listing['slug']],
                [
                    'service_category_id' => $category->id,
                    'provider_user_id' => $provider->id,
                    'title' => $listing['title'],
                    'short_description' => $listing['short_description'],
                    'description' => $listing['description'],
                    'price' => $listing['price'],
                    'currency' => $listing['currency'],
                    'sold_count' => $listing['sold_count'],
                    'rating_avg' => $listing['rating_avg'],
                    'rating_count' => $listing['rating_count'],
                    'delivery_time_days' => $listing['delivery_time_days'],
                    'revisions' => $listing['revisions'],
                    'is_active' => $listing['is_active'],
                ]
            );
        }
    }
}