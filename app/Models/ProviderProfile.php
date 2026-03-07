<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderProfile extends Model
{
    protected $fillable = [
        'user_id',
        'display_name',
        'headline',
        'bio',
        'country',
        'languages',
        'response_time',
        'last_delivery_note',
        'member_since',
        'avatar_path',
        'github_url',
    ];

    protected $casts = [
        'member_since' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}