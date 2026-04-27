<?php

namespace Modules\Merchant\Actions;

use App\Actions\SendMail;
use App\Enums\CacheKey;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Modules\Merchant\Models\Merchant;

class UpdateMerchant
{
    public function __construct(protected SendMail $sendMail) {}

    public function handle(Merchant $merchant, array $data): Merchant
    {
        $validated = Validator::make($data, [
            'name' => ["sometimes", "string"],
            'email' => ["sometimes", "email", "string"],
            "password" => ["sometimes", "string"]
        ])->validate();

        $merchant->update($validated);

        if ($merchant->isDirty('email')) {
            $code = generateCode();
            Cache::put(CacheKey::EMAIL_VERIFY->dynamicKey($merchant->getMorphClass(), $merchant->getKey()), $code, 300);
            $this->sendMail->handle($merchant->email, "Email Verification", "mail.email_verification", ["otp" => $code]);
        }

        return $merchant;
    }
}
