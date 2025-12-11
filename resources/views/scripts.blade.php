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
                } else {
                    document.documentElement.classList.add('fi-subnav-collapsed');
                }
                
                // Sync cookie
                const val = !this.isOpen ? 'true' : 'false';
                document.cookie = `subnav_collapsed=${val}; path=/; max-age=31536000`;
                
                // Reinitialize tooltips
                this.initTooltips();
            },

            initTooltips() {
                // Add tooltips to collapsed sidebar items
                setTimeout(() => {
                    const sidebar = document.querySelector('.fi-page-sub-navigation-sidebar');
                    if (!sidebar) return;

                    const items = sidebar.querySelectorAll('.fi-sidebar-item');
                    items.forEach(item => {
                        const button = item.querySelector('.fi-sidebar-item-button');
                        const label = item.querySelector('.fi-sidebar-item-label');
                        
                        if (button && label) {
                            const labelText = label.textContent.trim();
                            
                            if (!this.isOpen) {
                                // Add tooltip when collapsed
                                button.setAttribute('x-tooltip', `{content: '${labelText}', theme: $store.theme}`);
                            } else {
                                // Remove tooltip when expanded
                                button.removeAttribute('x-tooltip');
                            }
                        }
                    });

                    // Reinitialize Alpine components
                    if (window.Alpine) {
                        Alpine.initTree(sidebar);
                    }
                }, 100);
            }
        });

        // Enable transitions after load and init tooltips
        setTimeout(() => {
            document.documentElement.classList.add('fi-subnav-ready');
            Alpine.store('subnav').initTooltips();
        }, 50);
    });
</script>
