<?php

namespace Modules\Merchant\Filament\Pages;

use BackedEnum;
use Filament\Forms\Components\Radio;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Modules\Merchant\Models\Merchant;
use UnitEnum;

class SwitchBusiness extends Page
{
    protected string $view = 'merchant::filament.pages.switch-business';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static ?string $navigationLabel = 'Switch Business';
    protected static string|UnitEnum|null $navigationGroup = 'Settings';
    protected static bool $shouldRegisterNavigation = false;

    public ?int $business_id = null;

    public function mount(): void
    {
        /** @var Merchant $merchant */
        $merchant = Auth::user();
        $this->business_id = $merchant->active_business_id;
    }

    public function form(Schema $schema): Schema
    {
        /** @var Merchant $merchant */
        $merchant = Auth::user();

        $businesses = $merchant->businesses()
            ->pluck('name', 'id')
            ->all();

        return $schema
            ->components([
                Radio::make('business_id')
                    ->label('Select Active Business')
                    ->options($businesses)
                    ->required(),
            ])
            ->statePath('');
    }

    public function switch(): void
    {
        /** @var Merchant $merchant */
        $merchant = Auth::user();

        $this->form->validate();

        // ensure the business belongs to this merchant
        $business = $merchant->businesses()->findOrFail($this->business_id);

        $merchant->update(['active_business_id' => $business->id]);

        Notification::make()
            ->title("Switched to {$business->name}")
            ->success()
            ->send();

        $this->redirect(filament()->getHomeUrl());
    }

    protected function getForms(): array
    {
        return ['form'];
    }
}
