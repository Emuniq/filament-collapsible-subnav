# Filament Collapsible Sub-Navigation

A Filament v4 plugin that provides a collapsible sidebar for sub-navigation pages (e.g., when using `->subNavigationPosition(SubNavigationPosition::Start)`). It persists state across reloads and supports responsive layouts.

## Installation

### 1. Register the Plugin & Layout
In your `AdminPanelProvider` (usually `app/Providers/Filament/AdminPanelProvider.php`), register the plugin and override the layout:

```php
use Emuniq\FilamentCollapsibleSubnav\CollapsibleSubnavPlugin;
use Emuniq\FilamentCollapsibleSubnav\View\Components\Layout;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugin(new CollapsibleSubnavPlugin())
        ->layout(Layout::class);
}
```

### 2. Import CSS
Add the plugin's CSS to your theme's stylesheet (e.g., `resources/css/filament/admin/theme.css`). Since this plugin uses Tailwind v4 `@source` directives, it integrates natively.

```css
@import '../../../../packages/filament-collapsible-subnav/resources/css/theme.css'; 
/* Adjust path if installed via composer to 'vendor/emuniq/filament-collapsible-subnav/resources/css/theme.css' */

/* If installed via vendor: */
/* @import '../../../../vendor/emuniq/filament-collapsible-subnav/resources/css/theme.css'; */
```

## Features
- **Collapsible Sidebar**: Adds a toggle button to the sub-navigation sidebar.
- **Persistence**: Remembers state (collapsed/expanded) via cookies.
- **Zero FOUC**: Server-side rendering ensures no flash of unstyled content.
- **Tablet Friendly**: Toggle logic respects responsive breakpoints.
