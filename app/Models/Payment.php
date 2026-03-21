<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_FAILED = 'failed';
    public const STATUS_REFUNDED = 'refunded';

    protected $fillable = [
        'order_id',
        'payer_user_id',
        'payee_user_id',
        'payment_reference',
        'amount',
        'currency',
        'payment_method',
        'status',
        'paid_at',
        'metadata',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_user_id');
    }

    public function payee()
    {
        return $this->belongsTo(User::class, 'payee_user_id');
    }
}
