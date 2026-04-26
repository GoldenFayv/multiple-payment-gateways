<?php

namespace App\Actions;

use App\Enums\CacheKey;
use App\Interface\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class VerifyEmail
{
    public function handle(User $user, array $payload)
    {
        $validated = Validator::make($payload, ["code" => ["required"]])->validate();

        $cacheKey = CacheKey::EMAIL_VERIFY->dynamicKey($user->getMorphClass(), $user->getKey());

        $code = Cache::get($cacheKey);

        if ($code !== $validated['code']) {
            throw ValidationException::withMessages([
                'data.code' => 'Invalid or expired verification code.',
            ]);
        }

        Cache::forget($cacheKey);

        $user->update([
            'email_verified_at' => now(),
        ]);
    }
}
