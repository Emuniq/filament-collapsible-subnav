<?php

namespace Emuniq\FilamentCollapsibleSubnav;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Filament\Panel;

class CollapsibleSubnavServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-collapsible-subnav');

        FilamentAsset::register([
            Css::make('collapsible-subnav', __DIR__ . '/../resources/css/plugin.css'),
        ], 'emuniq/filament-collapsible-subnav');

        // Auto-register plugin to all panels
        Panel::configureUsing(function (Panel $panel) {
            $panel->plugin(CollapsibleSubnavPlugin::make());
        });
    }
}
