<?php

namespace Modules\Merchant\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Merchant\Services\ApiKeyService;

// use Modules\Merchant\Database\Factories\MerchantAppFactory;

#[Fillable('merchant_id', 'name', 'description', 'webhook_url', 'status')]
class MerchantApp extends Model
{
    use HasFactory;

    public function __construct(protected ApiKeyService $apiKeyService) {}

    public function apikeys()
    {
        return $this->hasMany(ApiKey::class, 'merchant_app_id');
    }

    public function generateKeys()
    {
        if ($this->status !== 'active') {
            $this->apiKeyService->generateKeyPair('test');
        }
    }
    // protected static function newFactory(): MerchantAppFactory
    // {
    //     // return MerchantAppFactory::new();
    // }
}
