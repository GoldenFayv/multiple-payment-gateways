<?php

namespace Modules\PaymentCore\Actions;

use App\Exceptions\CustomRuntimeException;
use Carbon\Carbon;
use Modules\PaymentCore\Enums\Enum\PaymentStatus;
use Modules\PaymentCore\Models\Transaction;
use Modules\PaymentCore\Services\GatewayManager;
use RuntimeException;

class VerifyPayment
{
    public function __construct(protected GatewayManager $gatewayManager) {}

    public function handle(string $reference): Transaction
    {
        $transaction = Transaction::query()
            ->where('internal_reference', $reference)
            ->first();

        if (! $transaction) {
            throw new CustomRuntimeException('Transaction not found.');
        }

        $gateway = $this->gatewayManager->driver($transaction->gateway);

        $result = $gateway->verify($transaction->internal_reference);

        $update = [
            'status' => $result->status,
            'gateway_reference' => $result->gatewayReference ?: $transaction->gateway_reference,
            'gateway_response' => $result->raw,
        ];

        if ($result->status === PaymentStatus::SUCCESSFUL && ! $transaction->paid_at) {
            $update['paid_at'] = Carbon::now();
        }

        $transaction->update($update);

        return $transaction->fresh();
    }
}
