@php
    $isRtl = __('filament-panels::layout.direction') === 'rtl';
    $isCollapsed = ($_COOKIE['subnav_collapsed'] ?? 'false') === 'true';
@endphp

<div 
    class="fi-subnav-toggle-wrapper"
    x-data="{}"
>
    <x-filament::icon-button
        color="gray"
        :icon="$isRtl ? 'heroicon-o-chevron-right' : 'heroicon-o-chevron-left'"
        icon-size="md"
        :label="__('filament-panels::layout.actions.sidebar.collapse.label')"
        x-show="$store.subnav?.isOpen"
        x-on:click="$store.subnav?.toggle()"
        style="{{ $isCollapsed ? 'display: none;' : '' }}"
    />
    
    <x-filament::icon-button
        color="gray"
        :icon="$isRtl ? 'heroicon-o-chevron-left' : 'heroicon-o-chevron-right'"
        icon-size="md"
        :label="__('filament-panels::layout.actions.sidebar.expand.label')"
        x-show="! $store.subnav?.isOpen"
        x-on:click="$store.subnav?.toggle()"
        style="{{ ! $isCollapsed ? 'display: none;' : '' }}"
    />
</div>
