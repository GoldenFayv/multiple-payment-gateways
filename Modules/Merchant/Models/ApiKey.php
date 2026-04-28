<?php

namespace Modules\Merchant\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Modules\Merchant\Database\Factories\ApiKeyFactory;
#[Fillable(['business_id', 'public_key', 'secret_key_hash', 'secret_key_last_four', 'environment', 'is_active', 'last_used_at', 'webhook_url'])]
class ApiKey extends Model
{
    use HasFactory;

    protected $casts = ['is_active' => 'boolean', 'last_used_at' => 'datetime', 'secret_key_hash' => 'hashed'];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
    // protected static function newFactory(): ApiKeyFactory
    // {
    //     // return ApiKeyFactory::new();
    // }
}
