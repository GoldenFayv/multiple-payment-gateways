<?php

namespace Modules\PaymentCore\Services;

use Illuminate\Support\Str;

class TransactionReferenceService
{
    public function generate(): string
    {
        return 'TXN_' . now()->format('YmdHis') . '_' . Str::upper(Str::random(8));
    }
}
