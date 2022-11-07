<?php

namespace Batyukovstudio\LaravelStaticImage\View\Components\Image;

use BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageConversionsCollection;
use BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageConversionSizesCollection;
use BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageConversionSizeValue;
use BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageConversionValue;
use BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageValue;
use Batyukovstudio\LaravelStaticImage\Values\SourcesCollection;
use Batyukovstudio\LaravelStaticImage\Values\SourceValue;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Image extends Component
{

    private $screens;
    private $formats;
    private $prefix;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->screens = laravel_static_image()['screens'] ?? [
                'xs' => 320,
                'sm' => 640,
                'md' => 768,
                'lg' => 1024,
                'xl' => 1280,
                'xxl' => 1536,
            ];

        $this->formats = laravel_static_image()['format'] ?? ['webp'];

        $this->prefix = laravel_static_image()['prefix'] ?? '_ebs_';

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

        $conversionsCollection = ImageConversionsCollection::run([]);

        foreach ($formats as $format) {

            $conversionValue = ImageConversionValue::run()
                ->setIsOriginal(false)
                ->setMimeType('image/' . $format);


            $sizesCollection = ImageConversionSizesCollection::run($sizes);

            foreach ($sizes as $size) {

                $src = $folder . $prefix . $fileName . '_' . $size . '.' . $format;
                $width = 0;

                if (strpos($size, ':')) {
                    $src = $folder . $prefix . $fileName . '_' . explode(':', $size)[1] . '.' . $format;
                    $width = $this->screens[explode(':', $size)[0]];
                }

                $sizeValue = ImageConversionSizeValue::run()
                    ->setSrc($src)
                    ->setHeight(null)
                    ->setWidth($width);

                $sizesCollection->push($sizeValue);
            }

            $conversionValue->setImageConversionSizesCollection($sizesCollection);
            $conversionsCollection->push($conversionValue);
        }

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
