<?php

namespace App\Providers\Filament;

use App\Filament\Pages\AccountSettings;
use App\Http\Middleware\EnsureEmailIsVerified;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Modules\Merchant\Filament\Pages\Auth\Register;
use Modules\Merchant\Filament\Pages\Dashboard;

class MerchantPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('merchant')
            ->path('merchant')
            ->login()
            ->passwordReset()
            ->authPasswordBroker('merchants')
            ->registration(Register::class)
            ->authGuard('merchant')
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Settings')
                    ->collapsed(),
            ])
            ->colors([
                'primary' => Color::Amber,
            ])
            // ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverResources(in: module_path('Merchant', "Filament/Resources"), for: 'Modules\\Merchant\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
                AccountSettings::class,
                // SwitchBusiness::class,
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Switch Business')
                    ->icon('heroicon-o-arrows-right-left')
                // ->url(fn() => SwitchBusiness::getUrl()),
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                EnsureEmailIsVerified::class,
            ]);
    }
}
