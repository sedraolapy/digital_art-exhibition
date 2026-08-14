<?php

namespace App\Filament\Resources\Experiences\Schemas;

use App\Enums\ExperienceStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class ExperienceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->rule('regex:/^[\p{Arabic}\p{N}\s.,،؛:!?؟()\-–—]+$/u')
                    ->hint('Enter the description in Arabic')
                    ->columnSpanFull(),
                DatePicker::make('start_date')
                    ->required()
                    ->live(),
                DatePicker::make('end_date')
                    ->after('start_date')
                    ->required(),
                Select::make('status')
                    ->options(ExperienceStatus::class)
                    ->default('draft')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('gallery')
                    ->collection('experience_gallery')
                    ->multiple()
                    ->image()
                    ->maxFiles(4)
                    ->maxSize(1024)
                    ->imageCropAspectRatio('16:9')
                    ->imageEditor()
                    ->hint('The image must be landscape (16:9 ratio), Maximum 4 images.')
                    ->validationMessages([
                        'max' => 'The image size must not exceed 1 MB.',
                    ])
                    ->preserveFilenames(),
            ]);
    }
}
