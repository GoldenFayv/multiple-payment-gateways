<?php

namespace Modules\Merchant\Filament\Resources\Transactions\Tables;

use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\PaymentCore\Enums\Enum\PaymentStatus;

class TransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('internal_reference')
                    ->label('Reference')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('customer_email')
                    ->label('Customer')
                    ->searchable(),

                TextColumn::make('gateway')
                    ->label('Gateway')
                    ->badge(),

                TextColumn::make('amount')
                    ->label('Amount')
                    ->formatStateUsing(
                        fn($state, $record) =>
                        strtoupper($record->currency) . ' ' . number_format($state / 100, 2)
                    ),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(PaymentStatus $state) => match ($state) {
                        PaymentStatus::SUCCESSFUL  => 'success',
                        PaymentStatus::PENDING     => 'warning',
                        PaymentStatus::PROCESSING  => 'info',
                        PaymentStatus::FAILED      => 'danger',
                        PaymentStatus::CANCELLED   => 'gray',
                    }),

                TextColumn::make('paid_at')
                    ->label('Paid At')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(
                        collect(PaymentStatus::cases())
                            ->mapWithKeys(fn($case) => [$case->value => ucfirst($case->value)])
                            ->all()
                    ),

                SelectFilter::make('gateway')
                    ->options([
                        'paystack'    => 'Paystack',
                        'flutterwave' => 'Flutterwave',
                        'stripe'      => 'Stripe',
                    ]),

                Filter::make('date_range')
                    ->form([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('created_at', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('created_at', '<=', $data['until']));
                    }),
            ])
            ->defaultSort('created_at', 'desc')
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
