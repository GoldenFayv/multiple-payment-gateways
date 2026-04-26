<?php

namespace Modules\Merchant\Actions;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\Merchant\Models\Merchant;

class CreateMerchant
{
    public function __construct(protected CreateOrUpdateBusiness $createOrUpdateBusiness, protected GenerateApiKey $generateMerchantApiKey) {}

    public function handle(array $payload): Merchant
    {
        $validated = Validator::make($payload, [
            'business_name' => ['required'],
            'email' => ['required', 'email', Rule::unique('merchants', 'email')],
            'phone' => ['required', Rule::unique('merchants', 'phone')],
            // 'password' => ['required', 'min:8', 'confirmed'],
        ])->validate();

        $validated['password'] = $payload['password'];
        $merchant = Merchant::create($validated);
        $business = $this->createOrUpdateBusiness->handle($merchant, $payload);
        $this->generateMerchantApiKey->handle($business);

        $merchant->update(['active_business_id' => $business->id]);
        return $merchant->fresh(['businesses']);
    }
}
