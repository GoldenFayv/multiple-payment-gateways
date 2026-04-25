<?php

namespace Modules\Paystack\Services;

use Illuminate\Http\Request;

class PaystackWebhookVerifier
{
    public function isValid(Request $request): bool
    {
        $signature = $request->header('x-paystack-signature');

        if (! $signature) {
            return false;
        }

        $computed = hash_hmac(
            'sha512',
            $request->getContent(),
            (string) config('paystack.secret_key')
        );

        return hash_equals($computed, $signature);
    }
}
