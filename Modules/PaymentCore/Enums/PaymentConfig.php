<?php

namespace Modules\PaymentCore\Enums;

enum PaymentConfig: string
{
    case PAYSTACK_GATEWAY_CLASS = "payment.gateway.paystack";
    case PAYSTACK_SIGNATURE_CHECK_CLASS = "payment.gateway.paystack.signature.check";
    case FLUTTER_GATEWAY_CLASS = "payment.gateway.flutterwave";
}
