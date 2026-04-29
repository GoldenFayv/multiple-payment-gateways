<?php

namespace Modules\Merchant\Filament\Resources\Transactions\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Merchant\Filament\Resources\Transactions\TransactionResource;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;
}
