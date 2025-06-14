@props([
    'size' => 'md', // sm, md, lg
    'color' => 'blue'
])

@php
$sizeClasses = [
    'sm' => 'h-4 w-4',
    'md' => 'h-6 w-6',
    'lg' => 'h-8 w-8',
    'xl' => 'size-12',
    '2xl' => 'size-16',
];

$colorClasses = [
    'blue' => 'text-blue-600',
    'white' => 'text-white dark:text-gray-900',
    'gray' => 'text-gray-600 dark:text-gray-300',
    'green' => 'text-green-600',
    'red' => 'text-red-600'
];

$spinnerSize = $sizeClasses[$size] ?? $sizeClasses['md'];
$spinnerColor = $colorClasses[$color] ?? $colorClasses['blue'];
@endphp

<div {{ $attributes->merge(['class' => 'inline-flex items-center']) }}>
    <svg class="animate-spin {{ $spinnerSize }} {{ $spinnerColor }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    @if($slot->isNotEmpty())
        <span class="ml-2">{{ $slot }}</span>
    @endif
</div>
