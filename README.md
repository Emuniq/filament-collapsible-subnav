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

## Usage

Simply register the plugin in your Panel Provider (e.g., `app/Providers/Filament/AdminPanelProvider.php`):

```php
use Emuniq\FilamentCollapsibleSubnav\CollapsibleSubnavPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugin(CollapsibleSubnavPlugin::make());
}
```

That's it! The plugin will automatically work with any Filament resource or page using sub-navigation.

## Features

- ✅ Zero configuration - works out of the box
- ✅ Collapsible sidebar toggle button
- ✅ Persistent state using cookies
- ✅ Server-side rendering support (no FOUC)
- ✅ Responsive design
- ✅ Smooth animations
- ✅ No build step required

## How It Works

The plugin automatically:
1. Injects CSS styles for the collapsible sidebar
2. Adds a toggle button to sub-navigation sidebars
3. Manages state persistence via cookies
4. Applies server-side rendering for seamless loading


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
