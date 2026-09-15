<?php

namespace App\Filament\Resources\Lectures\Schemas;

use App\Enums\EventOccurrenceStatus;
use App\Models\EventDay;
use App\Models\Lecture;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use App\Filament\Forms\Components\WebpMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class LectureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->rule('regex:/^[\p{Arabic}0-9٠-٩\s.,،!?؟()\-]+$/u')
                    ->required(),
                Textarea::make('description')
                    ->rule('regex:/^[\p{Arabic}0-9٠-٩\s.,،!?؟()\-]+$/u')
                    ->maxLength(80)
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('speaker_name')
                    ->required(),
                TextInput::make('max_seats')
                    ->required()
                    ->numeric(),
                Select::make('event_day_id')
                    ->label('Event day')
                    ->options(
                        EventDay::whereHas('occurrence', function ($q) {
                            $q->where('status', EventOccurrenceStatus::ACTIVE->value);
                        })->get()->mapWithKeys(fn ($day) => [
                            $day->id => 'يوم '.$day->day_number.' - '.$day->date,
                        ])
                    )
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $day = EventDay::find($state);
                        if ($day) {
                            $set('date', $day->date);
                        }
                    }),

                TimePicker::make('start_time')
                    ->label('Start Time')
                    ->required()
                    ->seconds(false)
                    ->live(),

                TimePicker::make('end_time')
                    ->label('End Time')
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

                WebpMediaLibraryFileUpload::make('image')
                    ->required()
                    ->collection('lectures')
                    ->image()
                    ->imageCropAspectRatio('16:9')
                    ->imageEditor()
                    ->hint('The image must be landscape (16:9 ratio)')
                    ->maxSize(1024)
                    ->validationMessages([
                        'max' => 'The image size must not exceed 1 MB.',
                    ]),
            ]);
    }
}
