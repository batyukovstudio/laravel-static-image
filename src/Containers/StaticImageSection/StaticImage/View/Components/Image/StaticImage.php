<?php

namespace Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\View\Components\Image;

use BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageConversionsCollection;
use BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageConversionSizesCollection;
use BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageConversionSizeValue;
use BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageConversionValue;
use BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageValue;
use Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Transformers\ImageFormatsTransformer;
use Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Transformers\ImageSizesTransformer;
use Illuminate\View\Component;

class StaticImage extends Component
{

    private array $screens;
    private array $formats;
    private string $prefix;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->screens = laravel_static_image()->getScreens();

        $this->formats = laravel_static_image()->getFormats();

        $this->prefix = laravel_static_image()->getPrefix();
    }

    /**
     * @param string $name
     * @return mixed
     */
    private function getAttribute(string $name): mixed
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * @param string $sizes
     * @return array
     */
    private function prepareSizes(string $sizes): array
    {
        $sizesArray = explode(' ', $sizes);
        return $sizesArray;
    }

    private function prepareValue(array $sizes, string $fileName, string $folder): ImageValue
    {
        $prefix = $this->prefix;
        $formats = $this->formats;

        $imageValue = ImageValue::run()
            ->setAlt($fileName)
            ->setWithGallery(false);

        $transformer = new ImageFormatsTransformer($sizes,$prefix, $folder, $fileName);
        $conversionsCollection = ImageConversionsCollection::run($formats, $transformer);

        $imageValue->setImageConversionsCollection($conversionsCollection);

        return $imageValue;
    }


    /**
     *
     */
    public function render()
    {


        $src = $this->getAttribute('src');

        $sizes = $this->getAttribute('sizes') ?? [];
        $sizes = $this->prepareSizes($sizes);


        $fileName = basename($src);
        $folder = dirname($src) . '/';


        $image = $this->prepareValue($sizes, $fileName, $folder);

        return view('image', compact('image'));
    }
}
