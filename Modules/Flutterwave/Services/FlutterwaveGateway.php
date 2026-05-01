<?php

namespace Modules\Flutterwave\Services;

use Illuminate\Http\Request;
use Modules\PaymentCore\Contracts\PaymentGatewayInterface;
use Modules\PaymentCore\DTOs\InitializePaymentData;
use Modules\PaymentCore\DTOs\VerifyPaymentResultData;
use Override;

class FlutterwaveGateway implements PaymentGatewayInterface
{
    public function __construct(public FlutterwaveClient $client, public FlutterwaveResponseMapper $mapper) {}

    public function initialize(InitializePaymentData $initializePaymentData): array
    {
        $payload = [
            "amount" => $initializePaymentData->amount,
            "tx_ref" => $initializePaymentData->reference,
            "currency" => $initializePaymentData->currency,
            "customer" => [
                "email" => $initializePaymentData->email
            ],
            'meta' => $initializePaymentData->metadata
        ];

        $channels = implode(',', $initializePaymentData->channels);
        if ($channels) {
            $payload['payment_options'] = $channels;
        }

        $response = $this->client->initializePayment("/payments", $payload);
        return [
            "payment_url" => data_get($response, 'data.link'),
        ];
    }

    #[Override]
    public function verify(string $reference): VerifyPaymentResultData
    {
        $response = $this->client->verifyTransaction("transactions/$reference/verify");
        $gatewayStatus = data_get($response, 'data.status');
        return new VerifyPaymentResultData(
            status: $this->mapper->mapStatus($gatewayStatus),
            gatewayReference: data_get($response, 'data.flw_ref'),
            message: data_get($response, 'message'),
            raw: data_get($response, 'data'),
        );
    }

    #[Override]
    public function handleWebhook(array $payload, array $headers = []): void
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function getCode(): string
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function checkSignature(Request $request): bool
    {
        throw new \Exception('Not implemented');
    }
}
