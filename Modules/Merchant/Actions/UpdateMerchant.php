<?php

namespace Modules\Merchant\Actions;

use App\Actions\SendMail;
use App\Enums\CacheKey;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Email;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\Validation\ValidationException;
use Modules\Merchant\Models\Merchant;

class UpdateMerchant
{
    public function __construct(protected SendMail $sendMail) {}

    public function handle(Merchant $merchant, array $data): Merchant
    {
        $validated = Validator::make($data, [
            'name' => ["sometimes", "string"],
            'email' => ["sometimes", "email", "string", Email::strict()->validateMxRecord()],
            "current_password" => [new RequiredIf(!empty($data['password']))],
            "password" => ["sometimes", "string", "confirmed", Password::min(8)->letters()->mixedCase()->numbers()->symbols()]
        ])->validate();

        if (!empty($validated['password'])) {
            if (!Hash::check($validated['current_password'], $merchant->password)) {
                throw ValidationException::withMessages([
                    "current_password" => "The current password you provided is incorrect."
                ]);
            }
        }

        $merchant->fill(Arr::except($validated, ['current_password']));

        if ($merchant->isDirty('email')) {
            $merchant->email_verified_at = null;

            $code = generateCode();

            Cache::put(
                CacheKey::EMAIL_VERIFY->dynamicKey($merchant->getMorphClass(), $merchant->getKey()),
                $code,
                300
            );

            $this->sendMail->handle($merchant->email, "Email Verification", "mail.email_verification", ["otp" => $code]);
        }

        $merchant->save();

        return $merchant;
    }
}
