<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Spatie\Image\Image;

class WebpMediaLibraryFileUpload extends SpatieMediaLibraryFileUpload
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->saveUploadedFileUsing(
            static function (
                WebpMediaLibraryFileUpload $component,
                TemporaryUploadedFile $file,
                ?Model $record
            ): ?string {
                if (! $record || ! method_exists($record, 'addMedia')) {
                    return null;
                }

                if (! $file->exists()) {
                    return null;
                }

                $tempPath = sys_get_temp_dir()
                    . DIRECTORY_SEPARATOR
                    . Str::ulid()
                    . '.webp';

                Image::load($file->getRealPath())
                    ->quality(70)
                    ->save($tempPath);

                $fileName = Str::ulid() . '.webp';

                $media = $record
                    ->addMedia($tempPath)
                    ->usingFileName($fileName)
                    ->toMediaCollection(
                        $component->getCollection() ?? 'default',
                        $component->getDiskName()
                    );

                return $media->uuid;
            }
        );
    }
}