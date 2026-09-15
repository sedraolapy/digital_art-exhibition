<?php

namespace App\Services\Media;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\Image\Image;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaStorageService
{
    public function storeImage(HasMedia $model,UploadedFile $image,string $collection): Media 
    {
        $tempDirectory = storage_path('app/media-temp');

        File::ensureDirectoryExists($tempDirectory);

        $fileName = Str::ulid() . '.webp';
        $tempPath = $tempDirectory . DIRECTORY_SEPARATOR . $fileName;

        Image::load($image->getRealPath())
            ->quality(70)
            ->save($tempPath);

        try {
            return $model
                ->addMedia($tempPath)
                ->usingFileName($fileName)
                ->toMediaCollection($collection);
        } finally {
            if (File::exists($tempPath)) {
                File::delete($tempPath);
            }
        }
    }
}