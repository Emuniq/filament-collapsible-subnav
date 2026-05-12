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
