<?php
namespace Modules\PaymentCore\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\PaymentCore\Actions\VerifyPayment;

class VerifyTransactionController
{
    public function __invoke(string $reference, VerifyPayment $verifyPayment): JsonResponse
    {
        $transaction = $verifyPayment->handle($reference);

        return response()->json([
            'status' => 'success',
            'data' => [
                'reference' => $transaction->internal_reference,
                'gateway' => $transaction->gateway,
                'status' => $transaction->status,
                'paid_at' => $transaction->paid_at,
            ],
        ]);
    }
}
