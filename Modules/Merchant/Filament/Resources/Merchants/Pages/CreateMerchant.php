<?php

namespace Modules\Merchant\Filament\Resources\Merchants\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Merchant\Filament\Resources\Merchants\MerchantResource;

class CreateMerchant extends CreateRecord
{
    protected static string $resource = MerchantResource::class;
}
