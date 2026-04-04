<?php

namespace Modules\Paystack\Services;

use Modules\PaymentCore\App\Services\BaseGatewayClient;

class PaystackClient extends BaseGatewayClient
{
    protected function baseUrl(): string
    {
        return config('paystack.base_url', 'https://api.paystack.co');
    }

    protected function headers(): array
    {
        return [
            'Authorization' => 'Bearer ' . config('paystack.secret_key'),
        ];
    }

    public function initializeTransaction(array $payload): array
    {
        return $this->post('/transaction/initialize', $payload);
    }

    public function verifyTransaction(string $reference): array
    {
        return $this->get("/transaction/verify/{$reference}");
    }
}
