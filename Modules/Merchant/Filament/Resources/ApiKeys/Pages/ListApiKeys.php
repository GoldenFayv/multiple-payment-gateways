<?php

namespace Modules\Merchant\Filament\Resources\ApiKeys\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use Modules\Merchant\Actions\GenerateApiKey;
use Modules\Merchant\Filament\Resources\ApiKeys\ApiKeyResource;

class ListApiKeys extends ListRecords
{
    protected static string $resource = ApiKeyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generateApiKey')
                ->label('Generate API Key')
                ->form([
                    Select::make('environment')
                        ->options([
                            'test' => 'Test',
                            'live' => 'Live',
                        ])
                        ->default('test')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $result = app(GenerateApiKey::class)->handle(Auth::user()->activeBusiness, $data['environment'],);

                    Notification::make()
                        ->title('API Key Generated')
                        ->body("Secret Key: {$result['secret_key']}")
                        ->success()
                        ->persistent()
                        ->send();
                }),
        ];
    }
}
