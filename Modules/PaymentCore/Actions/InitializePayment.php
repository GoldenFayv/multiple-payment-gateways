<?php

namespace Modules\PaymentCore\Actions;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\Merchant\Models\ApiKey;
use Modules\PaymentCore\DTOs\InitializePaymentData;
use Modules\PaymentCore\Enums\Enum\GatewayCode;
use Modules\PaymentCore\Enums\Enum\PaymentStatus;
use Modules\PaymentCore\Services\GatewayManager;
use Modules\PaymentCore\Services\TransactionReferenceService;

class InitializePayment
{
    public function __construct(protected GatewayManager $gatewayManager, protected TransactionReferenceService $referenceService) {}

    public function handle(ApiKey $apiKey, array $payload): array
    {
        $validated = Validator::make($payload, [
            'gateway' => ['required', Rule::enum(GatewayCode::class)],
            'amount' => ['required', 'numeric', 'min:50000'],
            'currency' => ['nullable', 'string'], //todo: Validate the currencies
            'email' => ['required', 'email'],
            'callback_url' => ['nullable', 'url'],
            'metadata' => ['nullable', 'array'],
            'channels' => ['nullable', 'array'],
        ])->validate();

        $reference = $this->referenceService->generate();

        $transaction = $apiKey->transactions()->create([
            'merchant_id' => $apiKey->merchant->id,
            'business_id' => $apiKey->business_id,
            'environment' => $apiKey->environment,
            'gateway' => $validated['gateway'],
            'internal_reference' => $reference,
            'amount' => $validated['amount'],
            'currency' => $validated['currency'] ?? "NGN",
            'customer_email' => $validated['email'],
            'status' => PaymentStatus::PENDING,
            'callback_url' => $validated['callback_url'] ?? null,
            'metadata' => $validated['metadata'] ?? [],
        ]);
        $initData = new InitializePaymentData(
            amount: $transaction->amount,
            currency: $transaction->currency,
            email: $transaction->customer_email,
            reference: $reference,
            callbackUrl: $transaction->callback_url ?? '',
            metadata: $transaction->metadata ?? [],
            channels: $transaction->channels ?? [],
        );
        $gateway = $this->gatewayManager->driver($validated['gateway']);

        $response = $gateway->initialize($initData);

        $transaction->update([
            'gateway_reference' => $response['gateway_reference'] ?? null,
            'gateway_response' => $response['raw'] ?? null,
        ]);

        return [
            'reference' => $reference,
            'gateway' => $validated['gateway'],
            'payment_url' => $response['payment_url'] ?? null,
        ];
    }
}
