<?php

namespace App\Filament\Widgets;

use Filament\Panel;
use Filament\Widgets\Widget;

class CustomInfoWidget extends Widget
{
    protected string $view = 'merchant::filament.widgets.custom-info-widget';

    public function canAccess(Panel $panel): bool
    {
        return $panel->getId() == "merchant";
    }
}
