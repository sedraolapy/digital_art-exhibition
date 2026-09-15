<?php

namespace App\Support\MediaLibrary;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class CollectionPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        return match ($media->collection_name) {
            'members' => 'members/',

            'experience_gallery' => 'experience/',

            'lectures' => 'lectures/',

            'sponsors' => 'sponsors/',

            'workshops' => 'workshops/',
            'workshop_gallery' => 'workshop-gallery/',

            'application_image' => 'applications/images/',
            'application_cv' => 'applications/cv/',

            'exhibitor_image' => 'exhibitors/images/',
            'exhibitor_cv' => 'exhibitors/cv/',

            'user_image' => 'users/',

            default => 'media/',
        };
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive-images/';
    }
}