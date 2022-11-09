<?php


namespace Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Transformers;


use BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageConversionSizeValue;
use BatyukovStudio\LaravelImageObject\Ship\Parents\Transformers\Transformer;
use BatyukovStudio\LaravelImageObject\Ship\Parents\Values\Value;

class ImageSizesTransformer extends Transformer
{

    public function __construct(protected string $prefix,
                                protected string $folder,
                                protected string $format,
                                protected string $filename)
    {

    }

    public function transform(mixed $size): Value
    {

        $src = $this->folder . $this->prefix . $this->filename . '_' . $size . '.' . $this->format;
        $width = 0;

        if (strpos($size, ':')) {

            $explodedSize = explode(':', $size);

            $src = $this->folder . $this->prefix . $this->filename . '_' . $explodedSize[1] . '.' . $this->format;

            $sizeKey = $explodedSize[0] ?? null;

            $width = laravel_static_image()->getScreens()[$sizeKey] ?? 0;
        }

        $sizeValue = ImageConversionSizeValue::run()
            ->setSrc($src)
            ->setHeight(null)
            ->setWidth($width);


        return $sizeValue;
    }
}