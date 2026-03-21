<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserProfile;
use App\Models\UserSetting;
use App\Models\ProviderProfile;
use App\Models\ServiceListing;
use App\Models\ServiceCategory;
use App\Models\Order;
use App\Models\Payment;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_CUSTOMER = 'customer';
    public const ROLE_PROVIDER = 'provider';
    public function profile()
{
    return $this->hasOne(UserProfile::class);
}

public function settings()
{
    return $this->hasOne(UserSetting::class);
}

public function providerProfile()
{
    return $this->hasOne(ProviderProfile::class);
}

public function serviceListings()
{
    return $this->hasMany(ServiceListing::class, 'provider_user_id');
}

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isCustomer(): bool
    {
        return $this->role === self::ROLE_CUSTOMER;
    }

    public function isProvider(): bool
    {
        return $this->role === self::ROLE_PROVIDER;
    }

    public function customerOrders()
{
    return $this->hasMany(Order::class, 'customer_user_id');
}

public function providerOrders()
{
    return $this->hasMany(Order::class, 'provider_user_id');
}

public function paymentsMade()
{
    return $this->hasMany(Payment::class, 'payer_user_id');
}

public function paymentsReceived()
{
    return $this->hasMany(Payment::class, 'payee_user_id');
}
}
