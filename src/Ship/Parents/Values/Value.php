<?php
namespace Batyukovstudio\LaravelStaticImage\Parents\Values;

abstract class Value
{
    public static function run(): static
    {
        $static = new static();
        $static->mount();
        return $static;
    }


    protected function mount()
    {

    }
}