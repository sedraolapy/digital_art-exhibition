<?php

namespace App\Filament\Resources\EventDays\Schemas;

use App\Models\EventDay;
use App\Models\EventOccurrence;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EventDayForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('event_occurrence_id')
                    ->label('Event Occurrence')
                    ->relationship('occurrence', 'title')
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->required(),
                TextInput::make('day_number')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->default(function (callable $get) {
                        $occurrenceId = $get('event_occurrence_id');

                        if (!$occurrenceId) {
                            return 1;
                        }

                        return EventDay::where('event_occurrence_id', $occurrenceId)->count() + 1;
                    }),

                DatePicker::make('date')
                    ->required()
                    ->reactive()
                    ->minDate(function (callable $get) {
                        $occurrenceId = $get('event_occurrence_id');
                        if (!$occurrenceId) return null;

                        $occurrence = EventOccurrence::find($occurrenceId);
                        return $occurrence?->start_date;
                    })
                    ->maxDate(function (callable $get) {
                        $occurrenceId = $get('event_occurrence_id');
                        if (!$occurrenceId) return null;

                        $occurrence = EventOccurrence::find($occurrenceId);
                        return $occurrence?->end_date;
                    })
                    ->rule(function (callable $get) {
                        $occurrenceId = $get('event_occurrence_id');
                        if (!$occurrenceId) return null;

                        $occurrence = EventOccurrence::find($occurrenceId);

                        return "after_or_equal:{$occurrence->start_date}|before_or_equal:{$occurrence->end_date}";
                    }),


            ]);
    }
}
