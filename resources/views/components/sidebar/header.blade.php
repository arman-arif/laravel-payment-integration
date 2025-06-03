@props([
    'barndUrl' => '/dashboard',
    'logoLight' => logo('light'),
    'logoDark' => logo('dark'),
    'logoIcon' => logo('icon')
])

<div
    :class="sidebarToggle ? 'justify-center' : 'justify-between'"
    class="flex items-center gap-2 pt-8 sidebar-header pb-7"
>
    <a href="{{ $barndUrl }}" class="block w-full">
        <div class="logo w-full" :class="sidebarToggle ? 'hidden' : ''">
            <div class="flex justify-center">
                <img class="dark:hidden h-10" src="{{ $logoLight }}" alt="Logo" />
                <img
                    class="hidden dark:block h-10"
                    src="{{ $logoDark }}"
                    alt="Logo"
                />
            </div>
        </div>

        <img
            class="logo-icon"
            :class="sidebarToggle ? 'lg:block' : 'hidden'"
            src="{{ $logoIcon }}"
            alt="Logo"
        />
    </a>
</div>
