<?php


namespace Batyukovstudio\LaravelStaticImage\Containers\StaticImageSection\StaticImage\Transformers;


use BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageConversionSizesCollection;
use BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageConversionSizeValue;
use BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageConversionValue;
use BatyukovStudio\LaravelImageObject\Ship\Parents\Transformers\Transformer;
use BatyukovStudio\LaravelImageObject\Ship\Parents\Values\Value;
use Illuminate\Support\Collection;

class ImageFormatsTransformer extends Transformer
{

    public function __construct(protected array $sizes,
                                protected string $prefix,
                                protected string $folder,
                                protected string $filename,
                                protected ?int $mainWidth
    )
    {
    }

    /**
     * @param mixed $format
     * @return ImageConversionValue
     */
    public function transform(mixed $format): ImageConversionValue
    {
        $sizesCollection = $this->prepareSizesCollection($format);

        $conversionValue = $this->doConversion($sizesCollection, $format);

        return $conversionValue;
    }


    private function doConversion(ImageConversionSizesCollection $sizesCollection, string $format,): ImageConversionValue
    {
        $conversionValue = ImageConversionValue::run()
            ->setIsOriginal(false)
            ->setMimeType('image/' . $format)
            ->setImageConversionSizesCollection($sizesCollection);

        return $conversionValue;

    }

    /**
     * @param string $format
     * @return ImageConversionSizesCollection
     */
    private function prepareSizesCollection(string $format): ImageConversionSizesCollection
    {
        if(count($this->sizes) === 0){
            $this->sizes[] = null;
        }

        $transformer = new ImageSizesTransformer($this->prefix, $this->folder, $format, $this->filename, $this->mainWidth);

        $sizesCollection = ImageConversionSizesCollection::run($this->sizes, $transformer);
        $sizesCollection = $sizesCollection->sortByDesc('width');
        return $sizesCollection;
    }
}
