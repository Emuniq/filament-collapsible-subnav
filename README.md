# Filament Collapsible Sub-Navigation

A Filament v4 plugin that provides a collapsible sidebar for sub-navigation pages (e.g., when using `->subNavigationPosition(SubNavigationPosition::Start)`). It persists state across reloads via cookies, supports server-side rendering to prevent FOUC, and is responsive.

![Expanded Sidebar](images/sidebar-expanded.png)
![Collapsed Sidebar](images/sidebar-collapsed.png)

## Requirements

- PHP 8.1+
- Laravel 10.0+
- Filament 4.0+

## Installation

Install the package via composer:

```bash
composer require emuniq/filament-collapsible-subnav
```

**That's it!** The plugin automatically registers itself to all Filament panels. No additional configuration needed.

## Features

- ✅ **Zero configuration** - Auto-registers to all panels
- ✅ Collapsible sidebar toggle button
- ✅ Persistent state using cookies
- ✅ Server-side rendering support (no FOUC)
- ✅ Responsive design
- ✅ Smooth animations
- ✅ No theme, npm, or build step required

## How It Works

The plugin automatically:
1. Registers itself to all Filament panels on installation
2. Injects CSS styles for the collapsible sidebar
3. Adds a toggle button to sub-navigation sidebars
4. Manages state persistence via cookies
5. Applies server-side rendering for seamless loading

## Manual Registration (Optional)

If you prefer manual control, you can prevent auto-registration and register the plugin manually:

```php
use Emuniq\FilamentCollapsibleSubnav\CollapsibleSubnavPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugin(CollapsibleSubnavPlugin::make());
}
```


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
