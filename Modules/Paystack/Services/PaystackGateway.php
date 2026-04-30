<?php

namespace Modules\Paystack\Services;

use Illuminate\Http\Request;
use Modules\PaymentCore\Contracts\PaymentGatewayInterface;
use Modules\PaymentCore\DTOs\InitializePaymentData;
use Modules\PaymentCore\DTOs\VerifyPaymentResultData;
use Modules\PaymentCore\Enums\Enum\GatewayCode;
use Modules\Paystack\Services\PaystackResponseMapper;
use Modules\Paystack\Services\PaystackClient;

class PaystackGateway implements PaymentGatewayInterface
{
    public function __construct(
        protected PaystackClient $client,
        protected PaystackResponseMapper $mapper,
    ) {}

    public function initialize(InitializePaymentData $data): array
    {
        $payload = [
            'email' => $data->email,
            'amount' => $data->amount,
            'currency' => $data->currency,
            'reference' => $data->reference,
            'callback_url' => $data->callbackUrl,
            'metadata' => $data->metadata,
        ];

        if (! empty($data->channels ?? [])) {
            $payload['channels'] = $data->channels;
        }

        $response = $this->client->initializeTransaction($payload);

        return [
            'payment_url' => data_get($response, 'data.authorization_url'),
            'access_code' => data_get($response, 'data.access_code'),
            'gateway_reference' => data_get($response, 'data.reference'),
            'raw' => $response,
        ];
    }

    public function verify(string $reference): VerifyPaymentResultData
    {
        $response = $this->client->verifyTransaction($reference);

        $gatewayStatus = data_get($response, 'data.status');

        return new VerifyPaymentResultData(
            status: $this->mapper->mapStatus($gatewayStatus),
            gatewayReference: data_get($response, 'data.reference'),
            message: data_get($response, 'message'),
            raw: $response,
        );
    }

    public function handleWebhook(array $payload, array $headers = []): void
    {
        // We'll keep real processing outside this class for clarity.
        // This method can later dispatch a job or delegate to a webhook service.
    }

    public function getCode(): string
    {
        return GatewayCode::PAYSTACK->value;
    }

    public function checkSignature(Request $request): bool
    {
        $signature = $request->header('x-paystack-signature');

        if (! $signature) {
            return false;
        }

        $computed = hash_hmac(
            'sha512',
            $request->getContent(),
            (string) config('paystack.secret_key')
        );

        return hash_equals($computed, $signature);
    }
}
