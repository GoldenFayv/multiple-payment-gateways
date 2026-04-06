<?php

namespace Modules\Merchant\Services;

use Illuminate\Support\Str;

class ApiKeyService
{
    public function generateKeyPair(string $environment = 'test'): array
    {
        $publicKey = "pk_{$environment}_" . Str::lower(Str::random(24));
        $secretKey = "sk_{$environment}_" . Str::lower(Str::random(48));

        return [
            'public_key' => $publicKey,
            'secret_key' => $secretKey,
            'secret_key_hash' => $secretKey,
            'secret_key_last_four' => substr($secretKey, -4),
        ];
    }
}
