<?php


namespace Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Tasks;


class CheckConfigDefaultValuesTask
{

    /**
     * @param array $config
     * @return array
     */
    public function run(array $config): array
    {
        $this->defineDefault($config, 'screens');
        $this->defineDefault($config, 'prefix');
        $this->defineDefault($config, 'formats');

        return $config;
    }


    /**
     * @param array $config
     * @param string $defaultAttributeName
     */
    private function defineDefault(array &$config, string $defaultAttributeName):void
    {
        if (!isset($config[$defaultAttributeName])) {
            $config[$defaultAttributeName] = config('laravel-static-image.default.' . $defaultAttributeName);
        }
    }

}