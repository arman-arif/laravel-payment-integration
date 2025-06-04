<?php

if (!function_exists('logo')) {
    function logo($type): string
    {
        return match ($type) {
            "light" => asset('assets/logo-light.png'),
            "dark" => asset('assets/logo-dark.png'),
            "icon" => asset('assets/logo-icon.png'),
            default => ''
        };
    }
}


if (!function_exists('user')) {
    function user($parameter = null)
    {
        if (!auth()->check()) {
            return null;
        }
        $user = auth()->user();
        if (!$parameter) {
            return auth()->user();
        }

        return $user->{$parameter} ?? null;
    }
}
