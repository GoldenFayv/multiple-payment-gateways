<?php

namespace Modules\Merchant\Filament\Resources\Merchants;

use App\Models\Admin;
use Modules\Merchant\Filament\Resources\Merchants\Pages\CreateMerchant;
use Modules\Merchant\Filament\Resources\Merchants\Pages\EditMerchant;
use Modules\Merchant\Filament\Resources\Merchants\Pages\ListMerchants;
use Modules\Merchant\Filament\Resources\Merchants\Schemas\MerchantForm;
use Modules\Merchant\Filament\Resources\Merchants\Tables\MerchantsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Modules\Merchant\Models\Merchant;

class MerchantResource extends Resource
{
    protected static ?string $model = Merchant::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    // protected static ?string $navigationLabel = 'Developers';

    protected static ?string $recordTitleAttribute = 'Merchant';

    public static function form(Schema $schema): Schema
    {
        return MerchantForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MerchantsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canAccess(): bool
    {
        return Auth::user() instanceof Admin; // only admin User, not Merchant
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMerchants::route('/'),
            'create' => CreateMerchant::route('/create'),
            'edit' => EditMerchant::route('/{record}/edit'),
        ];
    }
}
