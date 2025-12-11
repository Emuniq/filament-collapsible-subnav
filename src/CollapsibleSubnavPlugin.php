<?php

namespace Emuniq\FilamentCollapsibleSubnav;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;

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
            )
            ->renderHook(
                PanelsRenderHook::HEAD_START,
                fn () => view('filament-collapsible-subnav::scripts')
            )
            ->renderHook(
                PanelsRenderHook::HEAD_START,
                fn () => view('filament-collapsible-subnav::critical-css')
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
