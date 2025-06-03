@props([
    'class' => 'menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current'
])

<svg
    class="{{ $class }}"
    width="20"
    height="20"
    viewBox="0 0 20 20"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
    {{ $attributes }}
>
    <path
        d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
        stroke=""
        stroke-width="1.5"
        stroke-linecap="round"
        stroke-linejoin="round"
    />
</svg>
