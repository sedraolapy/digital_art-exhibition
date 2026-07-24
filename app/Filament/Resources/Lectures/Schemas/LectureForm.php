<?php

namespace App\Filament\Resources\Lectures\Schemas;

use App\Enums\EventOccurrenceStatus;
use App\Models\EventDay;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
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
                    ->rule('regex:/^[\p{Arabic}\s]+$/u')
                    ->required(),
                Textarea::make('description')
                    ->rule('regex:/^[\p{Arabic}\s]+$/u')
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
                DatePicker::make('date')
                    ->required()
                    ->disabled()
                    ->dehydrated()  
                    ->statePath('date'),
                TimePicker::make('start_time')
                    ->required(),
                TimePicker::make('end_time')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('image')
                    ->required()
                    ->collection('lectures')
                    ->image()
                    ->maxSize(1024)
                    ->validationMessages([
                        'max' => 'The image size must not exceed 1 MB.',
                    ])
                    ->preserveFilenames(),
            ]);
    }
}
