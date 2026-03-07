<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'headline',
        'description',
        'hero_image_path',
        'card_image_path',
        'is_active',
        'sort_order',
    ];

    public function listings()
    {
        return $this->hasMany(ServiceListing::class, 'service_category_id');
    }
}