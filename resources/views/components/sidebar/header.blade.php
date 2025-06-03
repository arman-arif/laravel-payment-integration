@props([
    'logoUrl' => 'index.html',
    'logoLight' => './images/logo/logo.svg',
    'logoDark' => './images/logo/logo-dark.svg',
    'logoIcon' => './images/logo/logo-icon.svg'
])

<!-- SIDEBAR HEADER -->
<div
    :class="sidebarToggle ? 'justify-center' : 'justify-between'"
    class="flex items-center gap-2 pt-8 sidebar-header pb-7"
>
    <a href="{{ $logoUrl }}">
        <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
            <img class="dark:hidden" src="{{ $logoLight }}" alt="Logo" />
            <img
                class="hidden dark:block"
                src="{{ $logoDark }}"
                alt="Logo"
            />
        </span>

        <img
            class="logo-icon"
            :class="sidebarToggle ? 'lg:block' : 'hidden'"
            src="{{ $logoIcon }}"
            alt="Logo"
        />
    </a>
</div>
<!-- SIDEBAR HEADER -->
