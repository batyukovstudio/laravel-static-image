<?php

namespace Batyukovstudio\LaravelStaticImage\Providers;

use App\Console\Commands\Cache;
use Illuminate\Support\ServiceProvider;


class LaravelStaticImageServiceProvider extends ServicePrrovider
{


    public function boot()
    {

        $this->publishes([
            __DIR__ . '/../../config/laravel-static-image.php' => config_path('laravel-static-image.php'),
        ]);

        $this->app->booted(function ($app) {

            $configData = \Cache::get(config('laravel-static-image-config.cache_config_name'));

            if (null === $configData) {
                $data = file_get_contents(base_path('config.json'));
                $configData = json_decode($data, true);
                \Cache::put(config('laravel-static-image-config.cache_config_name'), $configData);
            }

            $app[config('laravel-static-image-config.alias-config-name')] = $configData;

        });


    }

}