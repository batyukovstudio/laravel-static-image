<?php


namespace Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Transformers;


use BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageConversionSizesCollection;
use BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageConversionValue;
use BatyukovStudio\LaravelImageObject\Ship\Parents\Transformers\Transformer;
use BatyukovStudio\LaravelImageObject\Ship\Parents\Values\Value;

class ImageFormatsTransformer extends Transformer
{

    public function __construct(protected array $sizes,
                                protected string $prefix,
                                protected string $folder,
                                protected string $filename)
    {
    }

    /**
     * @param mixed $format
     * @return ImageConversionValue
     */
    public function transform(mixed $format): ImageConversionValue
    {

        $conversionValue = ImageConversionValue::run()
            ->setIsOriginal(false)
            ->setMimeType('image/' . $format);


        $transformer = new ImageSizesTransformer($this->prefix, $this->folder, $format, $this->filename);
        $sizesCollection = ImageConversionSizesCollection::run($this->sizes, $transformer);

        $conversionValue->setImageConversionSizesCollection($sizesCollection);

        return $conversionValue;
    }
}