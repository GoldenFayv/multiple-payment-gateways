<?php

namespace Modules\PaymentCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\PaymentCore\Enums\Enum\PaymentStatus;

// use Modules\PaymentCore\Database\Factories\TransactionFactory;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'merchant_id',
        'gateway',
        'internal_reference',
        'gateway_reference',
        'amount',
        'currency',
        'customer_email',
        'status',
        'callback_url',
        'metadata',
        'gateway_response',
        'paid_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'gateway_response' => 'array',
        'paid_at' => 'datetime',
        'status' => PaymentStatus::class,
    ];

    // protected static function newFactory(): TransactionFactory
    // {
    //     // return TransactionFactory::new();
    // }
}
