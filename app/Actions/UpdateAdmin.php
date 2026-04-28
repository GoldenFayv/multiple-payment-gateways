<?php

namespace App\Actions;

use App\Models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\Validation\ValidationException;

class UpdateAdmin
{
    public function __construct(protected SendMail $sendMail) {}

    public function handle(Admin $admin, array $data): Admin
    {
        $validated = Validator::make($data, [
            "name" => ["sometimes", "string"],
            "phone" => ["sometimes", "string"],
            "current_password" => [new RequiredIf(!empty($data['password']))],
            "password" => ["sometimes", "string", Password::min(8)->letters()->mixedCase()->numbers()->symbols()]
        ])->validate();

        // TODO(Golden): This password check can be made resuable for the Admin and Merchant model
        if (!empty($validated['password'])) {
            if (!Hash::check($validated['current_password'], $admin->password)) {
                throw ValidationException::withMessages([
                    "current_password" => "The current password you provided is incorrect."
                ]);
            }
        }

        $admin->update(Arr::except($validated, ['current_password']));

        return $admin->fresh();
    }
}
