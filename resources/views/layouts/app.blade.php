<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title> {{ config('app.name') }} - Billing & Payment </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body
    x-data="{ page: '{{ $page }}', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
        darkMode = JSON.parse(localStorage.getItem('darkMode'));
        $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))
    "
    :class="{'dark bg-gray-900': darkMode === true}"
>

{{-- <include src="./partials/preloader.html"></include> --}}

<div class="flex h-screen overflow-hidden">

    <x-partials.sidebar/>

    <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
        <div
            @click="sidebarToggle = false"
            :class="sidebarToggle ? 'block lg:hidden' : 'hidden'"
            class="fixed w-full h-screen z-9 bg-gray-900/50"
        ></div>

        <x-partials.header/>

        <main>
            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                {{ $header ?? '' }}

                {{ $slot }}
            </div>
        </main>
    </div>
</div>

@livewireScripts
</body>
</html>
