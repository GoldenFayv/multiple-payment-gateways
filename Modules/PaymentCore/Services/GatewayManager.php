<?php

namespace Modules\PaymentCore\Services;

use Modules\PaymentCore\Contracts\PaymentGatewayInterface;
use Modules\PaymentCore\Enums\PaymentConfig;

class GatewayManager
{
    public function driver(string $gateway): PaymentGatewayInterface
    {
        return match ($gateway) {
            'paystack' => app(PaymentConfig::PAYSTACK_GATEWAY_CLASS->value),
            'flutterwave' => app(PaymentConfig::FLUTTER_GATEWAY_CLASS->value),
            // default => throw new UnsupportedGatewayException(),
        };
    }
}
