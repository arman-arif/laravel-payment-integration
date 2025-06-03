@props([
    'name',
    'href' => '#',
    'icon',
    'hasDropdown' => false,
    'activePages' => [],
    'preventClick' => false
])

@php
$isActive = in_array($page ?? '', $activePages) || (isset($selected) && $selected === $name);
$clickHandler = $hasDropdown || $preventClick ? "@click.prevent=\"selected = (selected === '{$name}' ? '':'{$name}')\"" : '';
@endphp

<li>
    <a
        href="{{ $href }}"
        {!! $clickHandler !!}
        class="menu-item group"
        :class="(selected === '{{ $name }}') || {{ $isActive ? 'true' : 'false' }} ? 'menu-item-active' : 'menu-item-inactive'"
    >

        <x-icon
            :name="$icon"
            ::class="(selected === '{{ $name }}') || {{ $isActive ? 'true' : 'false' }} ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
        />

        <span
            class="menu-item-text"
            :class="sidebarToggle ? 'lg:hidden' : ''"
        >
            {{ $name }}
        </span>

        @if($hasDropdown)
            <x-icons.chevron-down
                ::class="[(selected === '{{ $name }}') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
            />
        @endif
    </a>

    @if($hasDropdown)
        <x-sidebar.menu-dropdown :name="$name">
            {{ $slot }}
        </x-sidebar.menu-dropdown>
    @endif
</li>
