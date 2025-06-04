@props([
    'type' => 'success', // success, error, warning, info
    'title' => '',
    'message' => '',
    'show' => false,
    'duration' => 5000
])

@php
$typeClasses = [
    'success' => [
        'bg' => 'bg-green-50 dark:bg-green-900/20',
        'border' => 'border-green-200 dark:border-green-800',
        'icon' => 'text-green-400',
        'title' => 'text-green-800 dark:text-green-200',
        'message' => 'text-green-700 dark:text-green-300'
    ],
    'error' => [
        'bg' => 'bg-red-50 dark:bg-red-900/20',
        'border' => 'border-red-200 dark:border-red-800',
        'icon' => 'text-red-400',
        'title' => 'text-red-800 dark:text-red-200',
        'message' => 'text-red-700 dark:text-red-300'
    ],
    'warning' => [
        'bg' => 'bg-yellow-50 dark:bg-yellow-900/20',
        'border' => 'border-yellow-200 dark:border-yellow-800',
        'icon' => 'text-yellow-400',
        'title' => 'text-yellow-800 dark:text-yellow-200',
        'message' => 'text-yellow-700 dark:text-yellow-300'
    ],
    'info' => [
        'bg' => 'bg-blue-50 dark:bg-blue-900/20',
        'border' => 'border-blue-200 dark:border-blue-800',
        'icon' => 'text-blue-400',
        'title' => 'text-blue-800 dark:text-blue-200',
        'message' => 'text-blue-700 dark:text-blue-300'
    ]
];

$classes = $typeClasses[$type] ?? $typeClasses['success'];
@endphp

<div 
    x-data="{ 
        show: @js($show),
        init() {
            if (this.show) {
                setTimeout(() => this.show = false, @js($duration));
            }
        }
    }"
    x-show="show"
    x-cloak
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg {{ $classes['bg'] }} {{ $classes['border'] }} border shadow-lg ring-1 ring-black ring-opacity-5"
    style="display: none;"
>
    <div class="p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                @if($type === 'success')
                    <svg class="h-6 w-6 {{ $classes['icon'] }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @elseif($type === 'error')
                    <svg class="h-6 w-6 {{ $classes['icon'] }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @elseif($type === 'warning')
                    <svg class="h-6 w-6 {{ $classes['icon'] }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                @else
                    <svg class="h-6 w-6 {{ $classes['icon'] }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                @endif
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
                @if($title)
                    <p class="text-sm font-medium {{ $classes['title'] }}">{{ $title }}</p>
                @endif
                @if($message)
                    <p class="mt-1 text-sm {{ $classes['message'] }}">{{ $message }}</p>
                @endif
            </div>
            <div class="ml-4 flex flex-shrink-0">
                <button 
                    type="button" 
                    class="inline-flex rounded-md {{ $classes['bg'] }} text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    @click="show = false"
                >
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>