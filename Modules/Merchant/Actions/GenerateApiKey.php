<?php

namespace Modules\Merchant\Actions;


use Illuminate\Support\Str;
use Modules\Merchant\Models\Business;

class GenerateApiKey
{
    public function handle(Business $business, string $environment = 'test'): array
    {
        $publicKey = 'pk_' . $environment . '_' . Str::random(32);
        $secretKey = 'sk_' . $environment . '_' . Str::random(48);

        $business->apiKeys()->where('environment', $environment)->delete();

        $apiKey = $business->apiKeys()->create([
            'environment' => $environment,
            'public_key' => $publicKey,
            'secret_key_hash' => $secretKey,
            'secret_key_last_four' => substr($secretKey, -4),
        ]);

        return [
            'api_key' => $apiKey,
            'secret_key' => $secretKey,
        ];
    }
}
