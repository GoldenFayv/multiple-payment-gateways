<?php
namespace Modules\PaymentCore\Exceptions;

use Illuminate\Support\Facades\Exceptions;

class UnsupportedGatewayException extends Exceptions
{
    public function __construct(string $gatewayCode)
    {
        parent::__construct("The payment gateway '{$gatewayCode}' is not supported.");
    }
}
