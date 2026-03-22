<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ServiceListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_category_id',
        'provider_user_id',
        'title',
        'slug',
        'short_description',
        'description',
        'price',
        'currency',
        'sold_count',
        'rating_avg',
        'rating_count',
        'delivery_time_days',
        'revisions',
        'thumbnail_path',
        'gallery_images',
        'is_active',
    ];

    protected $casts = [
        'gallery_images' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_user_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function orders()
    {
    return $this->hasMany(Order::class, 'service_listing_id');
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail_path && Storage::disk('public')->exists($this->thumbnail_path)) {
            return Storage::url($this->thumbnail_path);
        }

        return 'https://picsum.photos/seed/' . $this->slug . '/800/600';
    }

    public function getGalleryUrlsAttribute(): array
    {
        $images = collect($this->gallery_images ?? [])
            ->filter()
            ->filter(fn ($path) => Storage::disk('public')->exists($path))
            ->map(fn ($path) => Storage::url($path))
            ->values()
            ->all();

        if (! empty($images)) {
            return $images;
        }

        if ($this->thumbnail_path && Storage::disk('public')->exists($this->thumbnail_path)) {
            return array_fill(0, 5, Storage::url($this->thumbnail_path));
        }

        return array_fill(0, 5, 'https://picsum.photos/seed/' . $this->slug . '/1400/900');
    }
}
