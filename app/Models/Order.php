<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_user_id',
        'provider_user_id',
        'service_listing_id',
        'order_number',
        'amount',
        'currency',
        'scheduled_date',
        'scheduled_time',
        'status',
        'payment_status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'notes',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public const PAYMENT_UNPAID = 'unpaid';
    public const PAYMENT_PAID = 'paid';
    public const PAYMENT_REFUNDED = 'refunded';

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_user_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_user_id');
    }

    public function serviceListing()
    {
        return $this->belongsTo(ServiceListing::class, 'service_listing_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_IN_PROGRESS => 'On Going',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
            default => ucfirst(str_replace('_', ' ', (string) $this->status)),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'bg-amber-500/20 text-amber-300',
            self::STATUS_CONFIRMED => 'bg-sky-500/20 text-sky-300',
            self::STATUS_IN_PROGRESS => 'bg-indigo-500/20 text-indigo-300',
            self::STATUS_COMPLETED => 'bg-emerald-500/20 text-emerald-300',
            self::STATUS_CANCELLED => 'bg-rose-500/20 text-rose-300',
            default => 'bg-white/10 text-white/80',
        };
    }
}
