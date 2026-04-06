<?php

namespace Modules\Merchant\Actions;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\Merchant\Models\Merchant;

class CreateMerchant
{
    public function handle(array $payloads): Merchant
    {
        $validated = Validator::make($payloads, [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email', Rule::unique('merchants', 'email')],
            'phone' => ['required', Rule::unique('merchants', 'phone')],
            'password' => ['required', 'min:8', 'confirmed'],
        ])->validate();

        return Merchant::create($validated);
    }
}
