<?php

namespace Modules\Merchant\Filament\Resources\Merchants\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Modules\Merchant\Filament\Resources\Merchants\MerchantResource;

class EditMerchant extends EditRecord
{
    protected static string $resource = MerchantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
