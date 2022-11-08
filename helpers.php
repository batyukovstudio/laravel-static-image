<?php


use \Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Interfaces\LaravelStaticImage;

if (!function_exists('laravel_static_image')) {

    function laravel_static_image(): LaravelStaticImage
    {
        return app(LaravelStaticImage::class);
    }
}