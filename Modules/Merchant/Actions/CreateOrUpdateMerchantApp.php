<?php

namespace Modules\Merchant\Actions;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\Merchant\Models\Merchant;
use Modules\Merchant\Models\MerchantApp;

class CreateOrUpdateMerchantApp
{
    public function handle(Merchant $merchant, array $payloads, ?MerchantApp $merchantApp = null)
    {
        $validated = Validator::make($payloads, [
            'name' => ['required', Rule::unique('merchant_apps', 'name')->ignore($merchantApp?->id)->where('merchant_id', $merchant->id)],
            'description' => ['nullable'],
            'webhook_url' => ['required', 'url'],
        ])->validate();

        $app = $merchant->apps()->updateOrCreate(['id' => $merchantApp?->id], $validated);
        if($app->wasRecentlyCreated) {
            $app->generateKeys();
        }
        
        return $app;
    }
}
