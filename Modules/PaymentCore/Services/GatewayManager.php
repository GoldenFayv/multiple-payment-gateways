<?php

namespace Modules\PaymentCore\Services;

use Modules\PaymentCore\App\Contracts\PaymentGatewayInterface;
use Modules\PaymentCore\Exceptions\UnsupportedGatewayException;

class GatewayManager
{
    public function driver(string $gateway): PaymentGatewayInterface
    {
        return match ($gateway) {
            'paystack' => app('payment.gateway.paystack'),
            'flutterwave' => app('payment.gateway.flutterwave'),
            // default => throw new UnsupportedGatewayException(),
        };
    }
}
