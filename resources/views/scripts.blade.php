@php
    $isSubNavCollapsed = ($_COOKIE['subnav_collapsed'] ?? 'false') === 'true';
@endphp

@if ($isSubNavCollapsed)
    <script>
        document.documentElement.classList.add('fi-subnav-collapsed');
    </script>
@endif

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
                        
                        if (button && label && !button.hasAttribute('x-tooltip')) {
                            const labelText = label.textContent.trim();
                            button.setAttribute('x-tooltip', `{
                                content: '${labelText.replace(/'/g, "\\'")}',
                                theme: $store.theme,
                            }`);
                        }
                    });

                    // Reinitialize Alpine for new tooltips
                    if (window.Alpine && sidebar._x_dataStack === undefined) {
                        Alpine.initTree(sidebar);
                    }
                }, 250);
            },

            removeTooltips() {
                const sidebar = document.querySelector('.fi-page-sub-navigation-sidebar');
                if (!sidebar) return;

                const items = sidebar.querySelectorAll('.fi-sidebar-item-button[x-tooltip]');
                items.forEach(button => {
                    button.removeAttribute('x-tooltip');
                    // Destroy tooltip instance if exists
                    if (button._tippy) {
                        button._tippy.destroy();
                    }
                });
            }
        });

        // Enable transitions after load and init tooltips if collapsed
        setTimeout(() => {
            document.documentElement.classList.add('fi-subnav-ready');
            if (!Alpine.store('subnav').isOpen) {
                Alpine.store('subnav').addTooltips();
            }
        }, 300);
    });
</script>
