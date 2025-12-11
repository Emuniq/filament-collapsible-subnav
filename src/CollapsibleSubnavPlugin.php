<?php

namespace Emuniq\FilamentCollapsibleSubnav;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\View\PanelsRenderHook;

class CollapsibleSubnavPlugin implements Plugin
{
    public function getId(): string
    {
        return 'collapsible-subnav';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->renderHook(
                PanelsRenderHook::PAGE_SUB_NAVIGATION_SIDEBAR_BEFORE,
                fn () => view('filament-collapsible-subnav::toggle')
            );
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return new static();
    }
}
