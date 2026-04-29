<?php

namespace Modules\Merchant\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;
use Modules\Merchant\Models\Merchant;

class Dashboard extends BaseDashboard
{
    protected function getHeaderActions(): array
    {
        /** @var Merchant $merchant */
        $merchant = Auth::user();

        return [
            Action::make('switchBusiness')
                ->label('Switch Business')
                ->icon('heroicon-o-arrows-right-left')
                ->form([
                    Radio::make('business_id')
                        ->label('Select Business')
                        ->options(
                            $merchant->businesses()->pluck('name', 'id')->all()
                        )
                        ->default($merchant->active_business_id)
                        ->required(),
                ])
                ->action(function (array $data) use ($merchant) {
                    $business = $merchant->businesses()->findOrFail($data['business_id']);
                    $merchant->update(['active_business_id' => $business->id]);

                    Notification::make()
                        ->title("Switched to {$business->name}")
                        ->success()
                        ->send();
                }),
        ];
    }
}
