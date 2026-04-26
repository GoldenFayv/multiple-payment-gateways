<?php

namespace App\Actions;

use App\Enums\CacheKey;
use App\Models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateAdmin
{
    public function __construct(protected SendMail $sendMail) {}

    public function handle(array $payload): Admin
    {
        $validated = Validator::make($payload, [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email', Rule::unique('admins', 'email'), Rule::unique('merchants', 'email')],
            'phone' => ['required'],
            'password' => ['required', 'min:8', 'confirmed']
        ])->validate();

        $validated['name'] = "{$validated['first_name']} {$validated['last_name']}";
        $admin = Admin::create(Arr::except($validated, ['first_name', 'last_name']));

        $code = generateCode();

        Cache::put(CacheKey::EMAIL_VERIFY->dynamicKey($admin->getMorphClass(), $admin->getKey()), $code, 300);

        $this->sendMail->handle($admin->email, "Email Verification", 'mail.email_verification', ["otp" => $code, ...$admin->toArray()]);

        return $admin;
    }
}
