<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'is_active',
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
}