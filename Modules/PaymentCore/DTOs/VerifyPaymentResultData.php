<?php

namespace Modules\PaymentCore\DTOs;

use Modules\PaymentCore\Enums\Enum\PaymentStatus;

class VerifyPaymentResultData
{
    public function __construct(
        public PaymentStatus $status,
        public ?string $gatewayReference = null,
        public ?string $message = null,
        public array $raw = []
    ) {}
}
