<?php

namespace Spatie\MediaLibrary\ImageGenerators\FileTypes;

use Illuminate\Support\Collection;
use Spatie\MediaLibrary\Conversion\Conversion;
use Spatie\MediaLibrary\ImageGenerators\BaseGenerator;
class Image extends BaseGenerator
{
    public function convert($path, Conversion $conversion = null)
    {
        return $path;
    }
    public function requirementsAreInstalled()
    {
        return true;
    }
    public function supportedExtensions()
    {
        return collect(['png', 'jpg', 'jpeg', 'gif']);
    }
    public function supportedMimeTypes()
    {
        return collect(['image/jpeg', 'image/gif', 'image/png']);
    }
}