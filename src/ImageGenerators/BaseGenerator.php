<?php

namespace Spatie\MediaLibrary\ImageGenerators;

use Illuminate\Support\Collection;
use Spatie\MediaLibrary\Helpers\File;
use Spatie\MediaLibrary\Media;
use Spatie\MediaLibrary\UrlGenerator\UrlGeneratorFactory;
abstract class BaseGenerator implements ImageGenerator
{
    public function canConvert(Media $media)
    {
        if (!$this->requirementsAreInstalled()) {
            return false;
        }
        if ($this->supportedExtensions()->contains(strtolower($media->extension))) {
            return true;
        }
        $urlGenerator = UrlGeneratorFactory::createForMedia($media);
        if (method_exists($urlGenerator, 'getPath') && file_exists($media->getPath()) && $this->supportedMimetypes()->contains(strtolower(File::getMimetype($media->getPath())))) {
            return true;
        }
        return false;
    }
    public function canHandleMime($mime = '')
    {
        return $this->supportedMimetypes()->contains($mime);
    }
    public function canHandleExtension($extension = '')
    {
        return $this->supportedExtensions()->contains($extension);
    }
    public function getType()
    {
        return strtolower(class_basename(static::class));
    }
    public abstract function requirementsAreInstalled();
    public abstract function supportedExtensions();
    public abstract function supportedMimetypes();
}