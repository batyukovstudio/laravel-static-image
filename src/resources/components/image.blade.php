<?php
/**
 * @var $image \BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageValue
 * @var $imageConversion \BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageConversionValue
 * @var $imageConversionSize \BatyukovStudio\LaravelImageObject\Containers\ImageSection\Image\Value\ImageConversionSizeValue
 */
?>
<picture>

    @foreach($image->getImageConversionsCollection() as $imageConversion)
        @foreach($imageConversion->getImageConversionSizesCollection() as $imageConversionSize)

            <source srcset="{{ $imageConversionSize->getSrc() }}"
                    media="(min-width: {{ $imageConversionSize->getWidth() }}px)"
                    type="{{ $imageConversion->getMimeType() }}">

        @endforeach
    @endforeach

    <img src="{{ $src }}"
         @if ($alt) alt="{{ $alt }}" @endif
         @if ($width) width="{{ $width }}" @endif
         @if ($height) height="{{ $height }}" @endif
         @if ($class) class="{{ $class }}" @endif
         @if ($lazy) loading="lazy" @endif
    >
</picture>
