<?php

namespace Modules\PaymentCore\Http\Controllers;

use Illuminate\Http\Request;
use Modules\PaymentCore\Actions\VerifyPayment;

class CallbackController
{
    public function __invoke(Request $request, VerifyPayment $verifyPayment)
    {
        $reference = $request->query("tx_ref") ?? $request->query("reference");
//mydd($reference);
        $transaction = $verifyPayment->handle($reference);
    }
}
