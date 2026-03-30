<?php

namespace Modules\PaymentCore\Enums\Enum;

enum GatewayCode: string
{
    case PAYSTACK = 'paystack';
    case FLUTTERWAVE = 'flutterwave';
}
