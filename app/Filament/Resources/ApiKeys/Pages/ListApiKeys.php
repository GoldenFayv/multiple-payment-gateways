<?php

namespace App\Filament\Resources\ApiKeys\Pages;

use App\Filament\Resources\ApiKeys\ApiKeyResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Modules\Merchant\Actions\GenerateApiKey;

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
                    $result = app(GenerateApiKey::class)->handle(auth()->activeBusiness, $data['environment'],);

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
