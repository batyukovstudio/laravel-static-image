<?php


namespace Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Utilities;


use Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Actions\DefineConversionsConfigAction;
use Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Interfaces\LaravelStaticImage;

class LaravelStaticImageProcessor implements LaravelStaticImage
{
    /**
     * @var array
     */
    public array $configData;

    /**
     * LaravelStaticImageProcessor constructor.
     */
    public function __construct()
    {
        $this->configData = app(DefineConversionsConfigAction::class)->run();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return json_encode($this->configData);
    }

    /**
     * @return array
     */
    public function getConfigData(): array
    {
        return $this->configData;
    }

    /**
     * @return array
     */
    public function getFormats(): array
    {
       return $this->getConfigData()['formats'];
    }

    /**
     * @return array
     */
    public function getScreens(): array
    {
        return $this->getConfigData()['screens'];
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->getConfigData()['prefix'];
    }
}