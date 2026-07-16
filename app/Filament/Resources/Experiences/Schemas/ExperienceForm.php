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
                    ->required()
                    ->rule('regex:/^[\p{Arabic}\s]+$/u')
                    ->hint('Enter the description in Arabic')
                    ->columnSpanFull(),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date'),
                Select::make('status')
                    ->options(ExperienceStatus::class)
                    ->default('draft')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('gallery')
                    ->required()
                    ->collection('experience_gallery')
                    ->multiple()
                    ->image()
                    ->maxSize(1024)
                    ->validationMessages([
                        'max' => 'The image size must not exceed 1 MB.',
                    ])
                    ->preserveFilenames(),
            ]);
    }
}
