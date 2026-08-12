<?php

namespace App\Filament\Resources\Workshops\Schemas;

use App\Enums\WorkshopStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class WorkshopForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->rule('regex:/^[\p{Arabic}0-9٠-٩\s.,،!?؟()\-]+$/u')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->rule('regex:/^[\p{Arabic}0-9٠-٩\s.,،!?؟()\-]+$/u')
                    ->maxLength(80)
                    ->columnSpanFull(),
                TextInput::make('speaker_name')
                    ->required(),
                TextInput::make('max_seats')
                    ->required()
                    ->numeric(),
                DatePicker::make('date')
                    ->required(),
                TimePicker::make('start_time')
                    ->required()
                    ->seconds(false)
                    ->live(),
                TimePicker::make('end_time')
                    ->required()
                    ->seconds(false)
                    ->rules([
                        function ($get) {
                            return function (string $attribute, $value, \Closure $fail) use ($get) {

                                $startTime = $get('start_time');

                                if ($startTime && $value <= $startTime) {
                                    $fail('End time must be after start time.');
                                }
                            };
                        },
                    ]),
                Select::make('status')
                    ->options(WorkshopStatus::class)
                    ->required(),
                SpatieMediaLibraryFileUpload::make('image')
                    ->required()
                    ->collection('workshops')
                    ->image()
                    ->imageCropAspectRatio('16:9')
                    ->imageEditor()
                    ->hint('The image must be landscape (16:9 ratio)')
                    ->maxSize(1024)
                    ->validationMessages([
                        'max' => 'The image size must not exceed 1 MB.',
                    ])
                    ->preserveFilenames(),
                SpatieMediaLibraryFileUpload::make('gallery')
                    ->collection('workshop_gallery')
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
