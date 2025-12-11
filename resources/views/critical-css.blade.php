<style>
/* Critical CSS for preventing FOUC - loaded inline */
.fi-subnav-collapsed .fi-page-sub-navigation-sidebar-ctn {
    flex-basis: 4rem !important;
}

.fi-subnav-collapsed .fi-page-sub-navigation-sidebar .fi-sidebar-item-label,
.fi-subnav-collapsed .fi-page-sub-navigation-sidebar .fi-badge,
.fi-subnav-collapsed .fi-page-sub-navigation-sidebar .fi-sidebar-group-label {
    display: none;
}

.fi-subnav-collapsed .fi-page-sub-navigation-sidebar .fi-sidebar-item-button {
    justify-content: center;
    padding-left: 0.75rem;
    padding-right: 0.75rem;
}

.fi-page-main {
    display: flex;
    gap: 1.5rem;
}

.fi-page-sub-navigation-sidebar-ctn {
    flex-shrink: 0;
    flex-basis: 16rem;
}

.fi-page-content {
    flex: 1 1 0%;
    min-width: 0;
}
</style>
