<?php

namespace Modules\Merchant\Filament\Resources\Transactions;

use BackedEnum;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Modules\Merchant\Filament\Resources\Transactions\Pages\CreateTransaction;
use Modules\Merchant\Filament\Resources\Transactions\Pages\EditTransaction;
use Modules\Merchant\Filament\Resources\Transactions\Pages\ListTransactions;
use Modules\Merchant\Filament\Resources\Transactions\Schemas\TransactionForm;
use Modules\Merchant\Filament\Resources\Transactions\Tables\TransactionsTable;
use Modules\PaymentCore\Models\Transaction;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrows-right-left';

    protected static ?string $recordTitleAttribute = 'Transaction';

    public static function form(Schema $schema): Schema
    {
        return TransactionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransactionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canAccess(): bool
    {
        $panelId = Filament::getCurrentPanel()?->getId();
        return $panelId === "merchant";
    }

    public static function getEloquentQuery(): Builder
    {
        $merchant = Auth::user();

        return parent::getEloquentQuery()
            ->where('business_id', $merchant->active_business_id);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTransactions::route('/'),
            'create' => CreateTransaction::route('/create'),
            'edit' => EditTransaction::route('/{record}/edit'),
        ];
    }
}
