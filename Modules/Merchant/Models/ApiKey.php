<?php

namespace Modules\Merchant\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Merchant\Database\Factories\ApiKeyFactory;
#[Fillable('merchant_app_id', 'public_key', 'secret_key_hash', 'environment', 'is_active', 'last_used_at')]
class ApiKey extends Model
{
    use HasFactory;

    protected $casts = ['is_active' => 'boolean', 'last_used_at' => 'datetime', 'secret_key_hash' => 'hashed'];
    // protected static function newFactory(): ApiKeyFactory
    // {
    //     // return ApiKeyFactory::new();
    // }
}
