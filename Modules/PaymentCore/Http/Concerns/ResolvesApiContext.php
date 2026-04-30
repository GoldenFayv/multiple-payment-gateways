<?php

namespace Modules\PaymentCore\Http\Concerns;

use Modules\Merchant\Models\ApiKey;
use Modules\Merchant\Models\Business;
use Modules\PaymentCore\Enums\Environment;

trait ResolvesApiContext
{
    protected function getApiKey(): ApiKey
    {
        return request()->attributes->get('_api_key');
    }

    protected function getBusiness(): Business
    {
        return $this->getApiKey()->business;
    }

    protected function getEnvironment(): Environment
    {
        return $this->getApiKey()->environment;
    }

    protected function isTestMode(): bool
    {
        return $this->getEnvironment() === Environment::TEST;
    }

    protected function isLiveMode(): bool
    {
        return $this->getEnvironment() === Environment::LIVE;
    }
}
