<?php


namespace Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Providers;


use Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Interfaces\LaravelStaticImage;
use Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Utilities\LaravelStaticImageProcessor;
use Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\View\Components\Image\StaticImage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class MainServiceProvider extends ServiceProvider
{


    public function boot()
    {
        Blade::component('static-image', StaticImage::class);

        $this->app->singleton(LaravelStaticImage::class, LaravelStaticImageProcessor::class);

        $this->app->booted(function (Application $app) {

            if (true === $app['config']['laravel-static-image']['always_generate']) {
                $app->make(LaravelStaticImage::class);
            }

        });

    }

}