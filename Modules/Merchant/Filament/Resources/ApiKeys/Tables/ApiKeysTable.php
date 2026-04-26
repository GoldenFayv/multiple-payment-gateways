<?php

namespace Modules\Merchant\Filament\Resources\ApiKeys\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Modules\Merchant\Models\ApiKey;

class ApiKeysTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('public_key')
                    ->label('Public Key')
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->searchable(),

                TextColumn::make('secret_key_last_four')
                    ->label('Secret Key')
                    ->formatStateUsing(fn($state) => "****$state"),

                ToggleColumn::make('is_active')
                    ->label('Status')
                    ->onColor('success')
                    ->offColor('danger')
                    ->afterStateUpdated(function (ApiKey $apiKey, $state) {
                        $apiKey->update([
                            'is_active' => $state,
                        ]);
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // EditAction::make(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
