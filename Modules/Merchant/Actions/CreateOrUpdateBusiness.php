<?php

namespace Modules\Merchant\Actions;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\Merchant\Models\Business;
use Modules\Merchant\Models\Merchant;

class CreateOrUpdateBusiness
{
    public function handle(Merchant $merchant, array $payload): Business
    {
        $validated = Validator::make($payload, [
            'business_name' => [
                'required',
                Rule::unique('businesses', 'name')->where('merchant_id', $merchant->id),
            ],
        ])->validate();

        return $merchant->businesses()->updateOrCreate(
            [
                'name' => $validated['business_name'], // ← was $validated['name']
            ],
            [
                'merchant_id' => $merchant->id, // ← ensure merchant is always set
            ]
        );
    }
}
