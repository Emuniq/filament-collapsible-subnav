# Filament Collapsible Sub-Navigation

A Filament v4 plugin that provides a collapsible sidebar for sub-navigation pages (e.g., when using `->subNavigationPosition(SubNavigationPosition::Start)`). It persists state across reloads via cookies, supports server-side rendering to prevent FOUC, and is responsive.

![Expanded Sidebar](images/sidebar-expanded.png)
![Collapsed Sidebar](images/sidebar-collapsed.png)

## Installation

You can install the package via composer:

```bash
composer require emuniq/filament-collapsible-subnav
```

## Usage

### 1. Register the Plugin
In your `AdminPanelProvider` (e.g., `app/Providers/Filament/AdminPanelProvider.php`), register the plugin:

```php
use Emuniq\FilamentCollapsibleSubnav\CollapsibleSubnavPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugin(new CollapsibleSubnavPlugin());
}
```

### 2. Import CSS
Add the plugin's CSS to your theme's stylesheet (e.g., `resources/css/filament/admin/theme.css`).
This plugin uses Tailwind CSS v4 `@source` directives.

```css
@import '../../../../vendor/emuniq/filament-collapsible-subnav/resources/css/theme.css';
```
*(Note: Adjust the path if necessary. If developing locally via `path` repository, use the relative path to your packages folder).*

### 3. Override Layout
To apply the collapsible layout, you must override Filament's base layout component.
Create `resources/views/vendor/filament-panels/components/layout/base.blade.php` with the following content:

```blade
@props([
    'livewire' => null,
])

<x-filament-collapsible-subnav::layout :livewire="$livewire" :attributes="$attributes">
    {{ $slot }}
</x-filament-collapsible-subnav::layout>
```

This effectively wraps your panel in the collapsible sub-navigation layout.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
