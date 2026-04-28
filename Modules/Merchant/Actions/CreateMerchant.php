<?php

namespace Modules\Merchant\Actions;

use App\Actions\SendMail;
use App\Enums\CacheKey;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Email;
use Illuminate\Validation\Rules\Password;
use Modules\Merchant\Models\Merchant;

class CreateMerchant
{
    public function __construct(protected CreateOrUpdateBusiness $createOrUpdateBusiness, protected GenerateApiKey $generateApiKey, protected SendMail $sendMail) {}

    public function handle(array $payload): Merchant
    {
        $validated = Validator::make($payload, [
            'business_name' => ['required'],
            'email' => ['required', 'email', Rule::unique('merchants', 'email'), Email::strict()->validateMxRecord()],
            'phone' => ['required', Rule::unique('merchants', 'phone')],
            'password' => ['required', 'min:8', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ])->validate();

        $validated['password'] = $payload['password'];

        $merchant = Merchant::create($validated);

        $business = $this->createOrUpdateBusiness->handle($merchant, $payload);

        $this->generateApiKey->handle($business);

        $merchant->update(['active_business_id' => $business->id]);

        $code = generateCode();

        Cache::put(CacheKey::EMAIL_VERIFY->dynamicKey($merchant->getMorphClass(), $merchant->getKey()), $code, 300);

        $this->sendMail->handle($merchant->email, "Email Verification", 'mail.email_verification', ["otp" => $code, ...$merchant->toArray()]);

        return $merchant->fresh(['businesses']);
    }
}
