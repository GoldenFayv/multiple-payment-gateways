<?php

namespace Modules\Merchant\DTOs;

use Spatie\LaravelData\Data;

class MerchantData extends Data
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $email,
        public string $phone,
        public string $password,
        public bool $email_verified = false,
        public bool $phone_verified = false,
    ) {}
}
