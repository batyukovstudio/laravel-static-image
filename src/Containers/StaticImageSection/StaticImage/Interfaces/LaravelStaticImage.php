<?php


namespace Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Interfaces;


interface LaravelStaticImage
{
    public function getConfigData(): array;

    public function getFormats(): array;

    public function getScreens(): array;

    public function getPrefix(): string;

}