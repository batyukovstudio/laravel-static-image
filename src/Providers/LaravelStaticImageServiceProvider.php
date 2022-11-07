<?php

namespace Batyukovstudio\LaravelStaticImage\Providers;

use Batyukovstudio\LaravelStaticImage\Constants\NamesConstant;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Batyukovstudio\LaravelStaticImage\View\Components\Image\Image;

class LaravelStaticImageServiceProvider extends ServiceProvider
{


    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/laravel-static-image.php' => config_path('laravel-static-image.php'),
        ]);

        $this->app->booted(function (Application $app) {

            $configData = Cache::get(config('laravel-static-image-config.cache_config_name'));

            if (null === $configData) {
                $data = file_get_contents(base_path('ebs.config.json'));
                $configData = json_decode($data, true);
                Cache::put(config('laravel-static-image-config.cache_config_name'), $configData);
            }

            $app[NamesConstant::CONFIG_DATA_ALIAS_NAME] = $configData;

        });

        Blade::component('image', Image::class);
    }

}