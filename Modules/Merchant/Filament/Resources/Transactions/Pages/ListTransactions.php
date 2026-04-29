<?php

namespace Modules\Merchant\Filament\Resources\Transactions\Pages;

use Filament\Resources\Pages\ListRecords;
use Modules\Merchant\Filament\Resources\Transactions\TransactionResource;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
