<?php

namespace Modules\PaymentCore\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Merchant\Models\ApiKey;
use Modules\PaymentCore\Enums\Environment;

class AuthenticateApiKey
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $authHeader = $request->header('Authorization');

        // 1. Check header exists and is Bearer
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return $this->unauthorized('Missing or invalid Authorization header.');
        }

        $secretKey = substr($authHeader, 7); // strip "Bearer "

        // 2. Validate key format: sk_test_xxx or sk_live_xxx
        if (!preg_match('/^sk_(test|live)_/', $secretKey, $matches)) {
            return $this->unauthorized('Invalid API key format.');
        }

        $environment = Environment::tryFrom($matches[1]); // 'test' or 'live'

        if (!$environment) {
            return $this->unauthorized('Invalid API key environment.');
        }

        // 3. Find candidate keys by environment and last four
        $lastFour = substr($secretKey, -4);

        $apiKey = ApiKey::with('business')
            ->where('environment', $environment)
            ->where('secret_key_last_four', $lastFour)
            ->where('is_active', true)
            ->get()
            ->first(fn($key) => Hash::check($secretKey, $key->secret_key_hash));

        // 4. Validate key exists
        if (!$apiKey) {
            return $this->unauthorized('Invalid or inactive API key.');
        }

        // 5. Validate business exists and is active
        $business = $apiKey->business;

        if (!$business) {
            return $this->unauthorized('Business not found.');
        }

        // 6. Update last used timestamp
        $apiKey->update(['last_used_at' => now()]);

        // 7. Attach to request for use in controllers
        $request->attributes->set('_api_key', $apiKey);
        // $request->attributes->set('_business', $business);
        // $request->attributes->set('_environment', $environment);

        return $next($request);
    }

    private function unauthorized(string $message): JsonResponse
    {
        return failureResponse($message, response_code: 401);
    }
}
