<?php

namespace Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\View\Components\Image;

use App\Models\Users\User;
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


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $src,
        public string $alt = '',
        public ?string $sizes = null,
        public ?int $width = null,
        public ?int $height = null,
        public string $class = '',
        public bool $lazy = false,
    )
    {
    }


    /**
     * @param string $sizes
     * @return array
     */
    private function prepareSizes(string|array $sizes): array
    {
        if (is_string($sizes)) {
            $sizes = explode(' ', $sizes);
        }

        return $sizes;
    }

    private function prepareValue(array $sizes, string $fileName, string $folder): ImageValue
    {
        $prefix = laravel_static_image()->getPrefix();
        $formats = laravel_static_image()->getFormats();


        $transformer = new ImageFormatsTransformer($sizes, $prefix, $folder, $fileName,$this->width);
        $conversionsCollection = ImageConversionsCollection::run($formats, $transformer);


        $imageValue = ImageValue::run()
            ->setAlt($this->alt)
            ->setImageConversionsCollection($conversionsCollection);


        return $imageValue;
    }


    /**
     *
     */
    public function render()
    {
        $src = $this->src;

        $sizes = $this->sizes ?? [];

        $sizes = $this->prepareSizes($sizes);

        $fileName = pathinfo($src, PATHINFO_FILENAME);

        $folder = dirname($src) . '/';

        $image = $this->prepareValue($sizes, $fileName, $folder);


        return view('laravel-static-image::static-image', compact('image'));
    }
}
