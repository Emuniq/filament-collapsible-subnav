# Filament Collapsible Sub-Navigation

A Filament v3 & v4 plugin that adds a collapsible toggle to **sub-navigation sidebars only**. Perfect for resource pages with multiple tabs or sections using `->subNavigationPosition(SubNavigationPosition::Start)`.

Works with **both top navigation and sidebar navigation** layouts - the plugin specifically targets the sub-navigation sidebar that appears on individual resource pages, not the main panel navigation.

**Without Top Navigation (Sidebar Layout):**
![Expanded Sidebar](images/regular.png)

**With Top Navigation:**
![Collapsed Sidebar](images/topbar.png)

## Requirements

- PHP 8.1+
- Laravel 10.0+
- Filament 3.0+ or 4.0+

**Note:** This plugin only affects **sub-navigation sidebars** (the secondary navigation within resource pages), not the main panel sidebar. It works regardless of whether you use top navigation or sidebar navigation for your main panel layout.

## Installation

Install the package via composer:

```bash
composer require emuniq/filament-collapsible-subnav
```

**That's it!** The plugin automatically registers itself to all Filament panels. No additional configuration needed.

### Installation Methods

The plugin offers two installation approaches:

#### Option 1: Zero-Config (Default)
No setup required. Works immediately after composer install, but may have a slight flash on page refresh if using collapsed mode.

#### Option 2: Theme Integration (Recommended - No Flash)
For a completely flash-free experience, integrate the plugin CSS into your Filament theme:

1. Create a Filament theme if you don't have one:
```bash
php artisan make:filament-theme
```

2. Add the plugin's CSS to your theme file (e.g., `resources/css/filament/admin/theme.css`):
```css
@import '../../../../vendor/emuniq/filament-collapsible-subnav/resources/css/plugin.css';
```

3. Rebuild your theme:
```bash
npm run build
```

This approach eliminates any flash by including the CSS in your compiled theme.

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
3. Adds a toggle button to **sub-navigation sidebars only** (not main panel navigation)
4. Manages state persistence via cookies
5. Applies server-side rendering for seamless loading

The plugin detects pages with sub-navigation and only applies to those specific sidebars, leaving your main panel navigation (top or sidebar) untouched.

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
