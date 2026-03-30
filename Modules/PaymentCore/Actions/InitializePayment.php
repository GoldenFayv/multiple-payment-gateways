<?php

namespace Modules\PaymentCore\Actions;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\PaymentCore\DTOs\InitializePaymentData;
use Modules\PaymentCore\Enums\Enum\GatewayCode;
use Modules\PaymentCore\Enums\Enum\PaymentStatus;
use Modules\PaymentCore\Models\Transaction;
use Modules\PaymentCore\Services\GatewayManager;
use Modules\PaymentCore\Services\TransactionReferenceService;

class InitializePayment
{
    public function __construct(protected GatewayManager $gatewayManager, protected TransactionReferenceService $referenceService) {}

    public function handle(array $payload): array
    {
        $validated = Validator::make($payload, [
            'gateway' => ['required', Rule::enum(GatewayCode::class)],
            'amount' => ['required', 'numeric', 'min:50000'],
            'currency' => ['nullable', 'string'], //todo: Validate the currencies
            'email' => ['required', 'email'],
            'callback_url' => ['nullable', 'url'],
            'metadata' => ['nullable', 'array']
        ])->validate();

        $reference = $this->referenceService->generate();
        
        Transaction::create([
            'gateway' => $validated['gateway'],
            'internal_reference' => $reference,
            'amount' => $validated['amount'],
            'currency' => $validated['currency'],
            'customer_email' => $validated['email'],
            'status' => PaymentStatus::PENDING,
            'callback_url' => $validated['callback_url'] ?? null,
            'metadata' => $validated['metadata'] ?? [],
        ]);
        $initData = new InitializePaymentData(
            amount: $validated['amount'],
            currency: $validated['currency'],
            email: $validated['email'],
            reference: $reference,
            callbackUrl: $validated['callback_url'] ?? '',
            metadata: $validated['metadata'] ?? []
        );
        $gateway = $this->gatewayManager->driver($validated['gateway']);

        $response = $gateway->initialize($initData);
        return [
            'reference' => $reference,
            'gateway' => $validated['gateway'],
            'payment_url' => $response['payment_url'] ?? null,
        ];
    }
}
