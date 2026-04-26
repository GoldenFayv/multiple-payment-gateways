<?php

namespace Modules\Merchant\Filament\Resources\ApiKeys\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Merchant\Filament\Resources\ApiKeys\ApiKeyResource;

class CreateApiKey extends CreateRecord
{
    protected static string $resource = ApiKeyResource::class;
}
