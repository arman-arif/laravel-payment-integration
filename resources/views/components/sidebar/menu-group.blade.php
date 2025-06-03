@props(['title'])

<div>
    <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
        <span
            class="menu-group-title"
            :class="sidebarToggle ? 'lg:hidden' : ''"
        >
            {{ $title }}
        </span>

        <svg
            :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
            class="mx-auto fill-current menu-group-icon"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <x-icons.dots-horizontal />
        </svg>
    </h3>

    <ul class="flex flex-col gap-4 mb-6">
        {{ $slot }}
    </ul>
</div>
