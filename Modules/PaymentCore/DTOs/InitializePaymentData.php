<?php

namespace Modules\PaymentCore\DTOs;
class InitializePaymentData
{
    public function __construct(
        public int $amount,
        public string $currency,
        public string $email,
        public string $reference,
        public string $callbackUrl,
        public array $metadata = []
    ) {}
}
