<?php

namespace App\MediaLibrary;

use App\Models\Brand;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserTransaction;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

/**
 * Class CustomPathGenerator
 */
class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        $path = '{PARENT_DIR}'.DIRECTORY_SEPARATOR.$media->id.DIRECTORY_SEPARATOR;

        switch ($media->collection_name) {
            case User::PROFILE:
                return str_replace('{PARENT_DIR}', User::PROFILE, $path);
            case Setting::LOGO:
                return str_replace('{PARENT_DIR}', Setting::LOGO, $path);
            case Setting::FAVICON:
                return str_replace('{PARENT_DIR}', Setting::FAVICON, $path);
            case Brand::BRAND_LOGO:
                return str_replace('{PARENT_DIR}', Brand::BRAND_LOGO, $path);
            case UserTransaction::PAYMENT_ATTACHMENT:
                return str_replace('{PARENT_DIR}', UserTransaction::PAYMENT_ATTACHMENT, $path);
            case 'default':
                return '';
        }
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media).'thumbnails/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media).'rs-images/';
    }
}
