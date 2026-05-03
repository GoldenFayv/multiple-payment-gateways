<?php

namespace Modules\PaymentCore\Contracts;

use Illuminate\Http\Request;
use Modules\PaymentCore\DTOs\InitializePaymentData;
use Modules\PaymentCore\DTOs\VerifyPaymentResultData;

interface PaymentGatewayInterface
{
    public function initialize(InitializePaymentData $initializePaymentData): array;

    public function verify(string $reference): VerifyPaymentResultData;

    public function handleWebhook(array $payload, array $headers = []): void;

    public function getCode(): string;

    public function checkSignature(Request $request): bool;
}
