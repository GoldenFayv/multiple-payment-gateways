<?php

namespace Modules\Flutterwave\Services;

use Modules\PaymentCore\Services\BaseGatewayClient;

class FlutterwaveClient extends BaseGatewayClient
{
    protected function baseUrl(): string
    {
        return config('flutterwave.base_url');
    }

    protected function headers(): array
    {
        return [
            "Authorization" => "Bearer " . config("flutterwae.secret_key"),
            "Accept" => "application/json",
            "Content-Type" => "application/json",
        ];
    }

    public function initializePayment(string $url, array $payload): array
    {
        return $this->post($url, $payload);
    }

    public function verifyTransaction(string $url): array
    {
        return $this->get($url);
    }
}
