@props([
    'href',
    'activePage' => null
])

<li>
    <a
        href="{{ $href }}"
        class="menu-dropdown-item group"
        :class="page === '{{ $activePage }}' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'"
    >
        {{ $slot }}
    </a>
</li>
