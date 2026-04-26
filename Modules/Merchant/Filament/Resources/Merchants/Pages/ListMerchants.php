<?php

namespace Modules\Merchant\Filament\Resources\Merchants\Pages;


use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Merchant\Filament\Resources\Merchants\MerchantResource;

class ListMerchants extends ListRecords
{
    protected static string $resource = MerchantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
