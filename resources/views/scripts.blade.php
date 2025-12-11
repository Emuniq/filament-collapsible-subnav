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
            },
        });

        // Enable transitions after load
        setTimeout(() => document.documentElement.classList.add('fi-subnav-ready'), 50);
    });
</script>
