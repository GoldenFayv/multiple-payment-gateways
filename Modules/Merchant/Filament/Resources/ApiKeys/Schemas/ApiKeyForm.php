<?php

namespace Modules\Merchant\Filament\Resources\ApiKeys\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ApiKeyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('environment')
                    ->readOnly(),
                TextInput::make('webhook_url')
                    ->label("Webhook URL")
            ]);
    }
}
