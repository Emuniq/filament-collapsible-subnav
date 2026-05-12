<style>
    /* Critical inline CSS to prevent FOUC */
    .fi-page-main { display: flex; gap: 1.5rem; }
    .fi-page-sub-navigation-sidebar-ctn { flex-shrink: 0; flex-basis: 16rem; }
    .fi-page-content { flex: 1 1 0%; min-width: 0; }
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar-ctn { flex-basis: 4rem !important; }
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar .fi-sidebar-item-label,
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar .fi-badge,
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar .fi-sidebar-item-badge-ctn,
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar .fi-sidebar-group-label { display: none; }
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar .fi-sidebar-item-button,
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar .fi-sidebar-item-btn {
        justify-content: center;
        padding-left: 0.75rem;
        padding-right: 0.75rem;
        position: relative;
        overflow: visible;
    }
    /* Allow the tooltip to escape sidebar/group clipping. */
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar,
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar-ctn,
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar .fi-sidebar-group,
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar .fi-sidebar-group-items,
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar .fi-sidebar-item {
        overflow: visible !important;
    }
    /* CSS-only tooltip — works in v3/v4/v5, no JS deps, instant. */
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar [data-subnav-tooltip] {
        position: relative;
    }
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar [data-subnav-tooltip]::after {
        content: attr(data-subnav-tooltip);
        position: absolute;
        left: 100%;
        top: 50%;
        transform: translateY(-50%);
        margin-left: 0.5rem;
        background-color: rgb(17 24 39);
        color: rgb(255 255 255);
        padding: 0.375rem 0.625rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        line-height: 1;
        font-weight: 500;
        white-space: nowrap;
        z-index: 9999;
        opacity: 0;
        pointer-events: none;
        transition: opacity 120ms ease 40ms;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar [data-subnav-tooltip]:hover::after,
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar [data-subnav-tooltip]:focus-visible::after {
        opacity: 1;
    }
    .dark.fi-subnav-collapsed .fi-page-sub-navigation-sidebar [data-subnav-tooltip]::after {
        background-color: rgb(243 244 246);
        color: rgb(17 24 39);
    }
</style>

<script data-cfasync="false">
    // Apply collapsed class IMMEDIATELY before any rendering - runs synchronously
    // data-cfasync="false" prevents Cloudflare Rocket Loader from deferring this critical script
    (function() {
        var isCollapsed = document.cookie.split('; ').find(function(row) {
            return row.startsWith('subnav_collapsed=');
        });
        if (isCollapsed && isCollapsed.split('=')[1] === 'true') {
            document.documentElement.classList.add('fi-subnav-collapsed');
        }
    })();
</script>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('subnav', {
            isOpen: !document.documentElement.classList.contains('fi-subnav-collapsed'),

            toggle() {
                this.isOpen = !this.isOpen;
                if (this.isOpen) {
                    document.documentElement.classList.remove('fi-subnav-collapsed');
                    this.removeTooltips();
                } else {
                    document.documentElement.classList.add('fi-subnav-collapsed');
                    this.addTooltips();
                }
                
                // Sync cookie
                const val = !this.isOpen ? 'true' : 'false';
                document.cookie = `subnav_collapsed=${val}; path=/; max-age=31536000`;
            },

            addTooltips() {
                setTimeout(() => {
                    const sidebar = document.querySelector('.fi-page-sub-navigation-sidebar');
                    if (!sidebar) return;

                    sidebar.querySelectorAll('.fi-sidebar-item').forEach(item => {
                        // Filament v3 uses `.fi-sidebar-item-button`; v4+ uses `.fi-sidebar-item-btn`.
                        const button = item.querySelector('.fi-sidebar-item-btn, .fi-sidebar-item-button');
                        const label = item.querySelector('.fi-sidebar-item-label');

                        if (!button || !label) return;
                        if (button.hasAttribute('data-subnav-tooltip')) return;

                        const labelText = label.textContent.trim();
                        if (!labelText) return;

                        // The label itself is used by the CSS-only tooltip (::after)
                        // and as the accessible name. We deliberately avoid `title`
                        // because the browser's native tooltip is slow (1.5-3s).
                        button.setAttribute('data-subnav-tooltip', labelText);
                        button.setAttribute('aria-label', labelText);
                    });
                }, 350);
            },

            removeTooltips() {
                const sidebar = document.querySelector('.fi-page-sub-navigation-sidebar');
                if (!sidebar) return;

                sidebar.querySelectorAll('.fi-sidebar-item-btn, .fi-sidebar-item-button').forEach(button => {
                    button.removeAttribute('data-subnav-tooltip');
                    button.removeAttribute('aria-label');
                });
            }
        });

        const syncSubnavFromStore = () => {
            document.documentElement.classList.add('fi-subnav-ready');
            const subnavStore = Alpine.store('subnav');
            if (!subnavStore) return;

            if (subnavStore.isOpen) {
                document.documentElement.classList.remove('fi-subnav-collapsed');
                subnavStore.removeTooltips();
            } else {
                document.documentElement.classList.add('fi-subnav-collapsed');
                subnavStore.addTooltips();
            }
        };

        // Enable transitions after load and init tooltips if collapsed
        setTimeout(syncSubnavFromStore, 100);

        // Re-sync after Livewire SPA navigation
        document.addEventListener('livewire:navigated', syncSubnavFromStore);
    });
</script>
