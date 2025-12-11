# Filament Collapsible Sub-Navigation

A Filament v3 & v4 plugin that adds a collapsible toggle to **sub-navigation sidebars only**. Perfect for resource pages with multiple tabs or sections using `->subNavigationPosition(SubNavigationPosition::Start)`.

Works with **both top navigation and sidebar navigation** layouts - the plugin specifically targets the sub-navigation sidebar that appears on individual resource pages, not the main panel navigation.

![Expanded Sidebar](images/sidebar-expanded.png)
![Collapsed Sidebar](images/sidebar-collapsed.png)

## Requirements

- PHP 8.1+
- Laravel 10.0+
- Filament 3.0+ or 4.0+
- A Filament resource or page using `->subNavigationPosition(SubNavigationPosition::Start)`

**Note:** This plugin only affects **sub-navigation sidebars** (the secondary navigation within resource pages), not the main panel sidebar. It works regardless of whether you use top navigation or sidebar navigation for your main panel layout.

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

The plugin automatically:**sub-navigation sidebars only** (not main panel navigation)
4. Manages state persistence via cookies
5. Applies server-side rendering for seamless loading

The plugin detects pages with sub-navigation and only applies to those specific sidebars, leaving your main panel navigation (top or sidebar) untouched.
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
