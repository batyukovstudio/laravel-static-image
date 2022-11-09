<?php


namespace Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Tasks;


use Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Interfaces\LaravelStaticImage;

class ParseConversionConfigTask
{

    public function run(): LaravelStaticImage
    {
        $data = file_get_contents(base_path('conversion-config.json'));

        $configData = json_decode($data, true);

        return $configData;
    }

}