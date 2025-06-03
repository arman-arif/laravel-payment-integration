<?php

if (!function_exists('logo')) {
    function logo($type): string
    {
        return match ($type) {
            "light" => "https://phdcarrent.fo/uploads/logo/68cd981c2161a180f153a83f241de530.png",
            "dark" => "https://phdcarrent.fo/landing/img/logo.png",
            "icon" => "https://rentacar.aarif.co/uploads/images/4a2159534a0f291ac0d1d86823326214.png",
            default => ''
        };
    }
}
