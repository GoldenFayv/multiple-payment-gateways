<?php

namespace Modules\Merchant\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Modules\PaymentCore\Enums\Environment;
use Modules\PaymentCore\Models\Transaction;

// use Modules\Merchant\Database\Factories\ApiKeyFactory;
#[Fillable(['business_id', 'public_key', 'secret_key_hash', 'secret_key_last_four', 'environment', 'is_active', 'last_used_at', 'webhook_url'])]
class ApiKey extends Model
{
    use HasFactory;

    protected $casts = ['is_active' => 'boolean', 'last_used_at' => 'datetime', 'secret_key_hash' => 'hashed', 'enviroment' => Environment::class];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function merchant(): HasOneThrough
    {
        return $this->hasOneThrough(
            Merchant::class,
            Business::class,
            'id',          // foreign key on businesses table
            'id',          // foreign key on merchants table
            'business_id', // local key on api_keys table
            'merchant_id', // local key on businesses table
        );
    }
    // protected static function newFactory(): ApiKeyFactory
    // {
    //     // return ApiKeyFactory::new();
    // }
}
