<style>
    /* Critical inline CSS to prevent FOUC */
    .fi-page-main { display: flex; gap: 1.5rem; }
    .fi-page-sub-navigation-sidebar-ctn { flex-shrink: 0; flex-basis: 16rem; }
    .fi-page-content { flex: 1 1 0%; min-width: 0; }
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar-ctn { flex-basis: 4rem !important; }
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar .fi-sidebar-item-label,
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar .fi-badge,
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar .fi-sidebar-group-label { display: none; }
    .fi-subnav-collapsed .fi-page-sub-navigation-sidebar .fi-sidebar-item-button {
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

                    const items = sidebar.querySelectorAll('.fi-sidebar-item');
                    items.forEach(item => {
                        const button = item.querySelector('.fi-sidebar-item-button');
                        const label = item.querySelector('.fi-sidebar-item-label');
                        
                        if (button && label && !button.hasAttribute('data-tippy-content')) {
                            const labelText = label.textContent.trim();
                            
                            // Use Tippy directly for better compatibility
                            if (typeof tippy !== 'undefined') {
                                tippy(button, {
                                    content: labelText,
                                    theme: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light',
                                });
                            } else {
                                // Fallback: Set attribute for Alpine's x-tooltip directive
                                button.setAttribute('x-tooltip', JSON.stringify({
                                    content: labelText,
                                    theme: '$store.theme',
                                }));
                            }
                        }
                    });

                    // If using x-tooltip attributes, reinitialize Alpine
                    if (typeof tippy === 'undefined' && window.Alpine) {
                        Alpine.initTree(sidebar);
                    }
                }, 350);
            },

            removeTooltips() {
                const sidebar = document.querySelector('.fi-page-sub-navigation-sidebar');
                if (!sidebar) return;

                const items = sidebar.querySelectorAll('.fi-sidebar-item-button');
                items.forEach(button => {
                    // Destroy Tippy instance if it exists
                    if (button._tippy) {
                        button._tippy.destroy();
                    }
                    // Remove x-tooltip attribute
                    button.removeAttribute('x-tooltip');
                    button.removeAttribute('data-tippy-content');
                });
            }
        });

        // Enable transitions after load and init tooltips if collapsed
        setTimeout(() => {
            document.documentElement.classList.add('fi-subnav-ready');
            if (!Alpine.store('subnav').isOpen) {
                Alpine.store('subnav').addTooltips();
            }
        }, 100);
    });
</script>
