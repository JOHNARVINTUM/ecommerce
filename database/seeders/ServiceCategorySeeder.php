<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Programming',
                'slug' => 'programming',
                'headline' => 'Custom software and web development services',
                'description' => 'Find providers who build Laravel applications, business systems, websites, and custom tools.',
                'hero_image_path' => null,
                'card_image_path' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Web Design',
                'slug' => 'web-design',
                'headline' => 'Modern websites and landing page design',
                'description' => 'Discover professionals who design clean, responsive, and conversion-focused websites.',
                'hero_image_path' => null,
                'card_image_path' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Graphic Design',
                'slug' => 'graphic-design',
                'headline' => 'Creative assets for brands and businesses',
                'description' => 'Browse design services for marketing graphics, social media assets, brand kits, and more.',
                'hero_image_path' => null,
                'card_image_path' => null,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Video Editing',
                'slug' => 'video-editing',
                'headline' => 'Professional video editing for modern content',
                'description' => 'Hire editors for reels, promos, tutorials, ads, and professional video production work.',
                'hero_image_path' => null,
                'card_image_path' => null,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Photo Editing',
                'slug' => 'photo-editing',
                'headline' => 'Retouching and image enhancement services',
                'description' => 'Get help with photo cleanup, product images, portrait edits, and image optimization.',
                'hero_image_path' => null,
                'card_image_path' => null,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Logo Making',
                'slug' => 'logo-making',
                'headline' => 'Logo creation and visual identity services',
                'description' => 'Work with creators who design memorable logos and visual branding systems.',
                'hero_image_path' => null,
                'card_image_path' => null,
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create($category);
        }
    }
}