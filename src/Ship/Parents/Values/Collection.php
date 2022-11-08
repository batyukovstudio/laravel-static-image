<?php

namespace Batyukovstudio\LaravelStaticImage\Parents\Values;

use \Illuminate\Support\Collection as ParentCollection;

abstract class Collection extends ParentCollection
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