<?php


if (!function_exists('laravel_static_image')) {

    function laravel_static_image(): array
    {
        return app()[config('laravel-static-image-config.alias-config-name')];
    }
}