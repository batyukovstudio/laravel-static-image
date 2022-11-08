<?php


namespace Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Actions;

use Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Tasks\CheckConfigDefaultValuesTask;
use Illuminate\Support\Facades\Cache;

class DefineConversionsConfigAction
{

    public function run(): array
    {
        $config = config('laravel-static-image');

        $cacheName = $config['cache.config_name'];

        $configData = Cache::get($cacheName);

        if (null === $configData) {
            $configData = app(ParseConversionConfigTask::class)->run();

            $configData = app(CheckConfigDefaultValuesTask::class)->run($configData);

            if ($config['cache.should_cache']) {
                Cache::put($cacheName, $configData);
            }
        }

        return $configData;
    }

}