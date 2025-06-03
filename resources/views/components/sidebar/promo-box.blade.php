@props([
    'title' => 'Tailwind Dashboard',
    'description' => 'Leading Tailwind CSS Admin Template',
    'buttonText' => 'Purchase Plan',
    'buttonUrl' => '#'
])

<!-- Promo Box -->
<div
    :class="sidebarToggle ? 'lg:hidden' : ''"
    class="mx-auto mb-10 w-full max-w-60 rounded-2xl bg-gray-50 px-4 py-5 text-center dark:bg-white/[0.03]"
>
    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white">
        {{ $title }}
    </h3>
    <p class="mb-4 text-gray-500 text-theme-sm dark:text-gray-400">
        {{ $description }}
    </p>
    <a
        href="{{ $buttonUrl }}"
        target="_blank"
        rel="nofollow"
        class="flex items-center justify-center p-3 font-medium text-white rounded-lg bg-brand-500 text-theme-sm hover:bg-brand-600"
    >
        {{ $buttonText }}
    </a>
</div>
<!-- Promo Box -->
