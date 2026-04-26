<?php

namespace Modules\Merchant\Filament\Resources\ApiKeys;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\Merchant\Filament\Resources\ApiKeys\Pages\ListApiKeys;
use Modules\Merchant\Filament\Resources\ApiKeys\Schemas\ApiKeyForm;
use Modules\Merchant\Filament\Resources\ApiKeys\Tables\ApiKeysTable;
use Modules\Merchant\Models\ApiKey;
use UnitEnum;

class ApiKeyResource extends Resource
{
    protected static string|UnitEnum|null $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'API Keys';
    protected static ?int $navigationSort = 4;
    protected static ?string $model = ApiKey::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedKey;

    protected static ?string $recordTitleAttribute = 'Api Key';

    public static function form(Schema $schema): Schema
    {
        return ApiKeyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApiKeysTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApiKeys::route('/'),
            // 'create' => CreateApiKey::route('/create'),
            // 'edit' => EditApiKey::route('/{record}/edit'),
        ];
    }


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('business', function ($query) {
            $query->where('business_id', auth('merchant')->user()->active_business_id);
        });
    }
}
