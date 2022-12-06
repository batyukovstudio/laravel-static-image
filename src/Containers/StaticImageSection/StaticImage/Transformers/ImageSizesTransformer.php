<?php


namespace Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Transformers;


use BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageConversionSizeValue;
use BatyukovStudio\LaravelImageObject\Ship\Parents\Transformers\Transformer;
use BatyukovStudio\LaravelImageObject\Ship\Parents\Values\Value;

class ImageSizesTransformer extends Transformer
{

    private const EXPLODED_BREAKPOINT_INDEX = 0;
    private const EXPLODED_SIZE_INDEX = 1;

    public function __construct(protected string $prefix,
                                protected string $folder,
                                protected string $format,
                                protected string $filename,
                                protected ?int $mainWidth,
    )
    {

    }

    /**
     * @param mixed $size
     * @return Value
     */
    public function transform(mixed $size): Value
    {
        [$src, $width] = $this->defineDataBySizeForConversion($size);

        $sizeValue = $this->doConversionValue($src, $width);

        return $sizeValue;
    }


    private function defineDataBySizeForConversion(mixed $size): array
    {
        $srcPrefix = $this->getSrcPrefix();

        /**
         * Стандартный src
         */
        $src = $srcPrefix . '_' . $size . '.' . $this->format;
        $width = 0;

        /**
         * Не пришли размеры
         */
        if (null === $size) {
            $width = $this->mainWidth;
            $src = $srcPrefix . '.' . $this->format;
        }

        /**
         * Указали размеры с брик поинтами
         */
        if (true === $this->isHasBreakpoint($size)) {

            $explodedSize = explode(':', $size);

            $src = $srcPrefix . '_' . $explodedSize[self::EXPLODED_SIZE_INDEX] . '.' . $this->format;

            $sizeKey = $explodedSize[self::EXPLODED_BREAKPOINT_INDEX] ?? null;

            $width = laravel_static_image()->getScreens()[$sizeKey] ?? 0;
        }

        return [$src, $width];
    }


    private function isHasBreakpoint(mixed $size): bool
    {
        return strpos($size, ':');
    }


    private function doConversionValue(string $src, int $width): ImageConversionSizeValue
    {
        $sizeValue = ImageConversionSizeValue::run()
            ->setSrc($src)
            ->setHeight(null)
            ->setWidth($width);

        return $sizeValue;
    }

    private function getSrcPrefix(): string
    {
        return $this->folder . $this->prefix . $this->filename;
    }


}
