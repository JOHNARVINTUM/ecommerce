<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'avatar_path',
        'phone',
        'location',
        'bio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}