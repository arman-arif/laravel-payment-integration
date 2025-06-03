@props(['name'])

<!-- Dropdown Menu Start -->
<div
    class="overflow-hidden transform translate"
    :class="(selected === '{{ $name }}') ? 'block' :'hidden'"
>
    <ul
        :class="sidebarToggle ? 'lg:hidden' : 'flex'"
        class="flex flex-col gap-1 mt-2 menu-dropdown pl-9"
    >
        {{ $slot }}
    </ul>
</div>
<!-- Dropdown Menu End -->
