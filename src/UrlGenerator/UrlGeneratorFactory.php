<?php

namespace Spatie\MediaLibrary\UrlGenerator;

use Spatie\MediaLibrary\Exceptions\InvalidUrlGenerator;
use Spatie\MediaLibrary\Media;
use Spatie\MediaLibrary\PathGenerator\PathGeneratorFactory;
class UrlGeneratorFactory
{
    public static function createForMedia(Media $media)
    {
        $urlGeneratorClass = config('laravel-medialibrary.custom_url_generator_class') ?: 'Spatie\\MediaLibrary\\UrlGenerator\\' . ucfirst($media->getDiskDriverName()) . 'UrlGenerator';
        static::guardAgainstInvalidUrlGenerator($urlGeneratorClass);
        $urlGenerator = app($urlGeneratorClass);
        $pathGenerator = PathGeneratorFactory::create();
        $urlGenerator->setMedia($media)->setPathGenerator($pathGenerator);
        return $urlGenerator;
    }
    public static function guardAgainstInvalidUrlGenerator($urlGeneratorClass)
    {
        if (!class_exists($urlGeneratorClass)) {
            throw InvalidUrlGenerator::doesntExist($urlGeneratorClass);
        }
        if (!is_subclass_of($urlGeneratorClass, UrlGenerator::class)) {
            throw InvalidUrlGenerator::isntAUrlGenerator($urlGeneratorClass);
        }
    }
}