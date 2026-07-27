<?php

namespace App\Filament\Resources\EventOccurrences\Schemas;

use App\Models\Cycle;
use App\Models\Location;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EventOccurrenceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->rule('regex:/^[\p{Arabic}\s0-9٠-٩]+$/u')
                    ->maxLength(255),

                Select::make('cycle_id')
                    ->relationship('cycle', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('location_id')
                    ->relationship('location', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('start_date')
                    ->required()
                    ->reactive()
                    ->minDate(function (callable $get) {
                        $cycleId = $get('cycle_id');
                        if (!$cycleId) return null;

                        $cycle = Cycle::find($cycleId);
                        return $cycle?->start_date;
                    })
                    ->maxDate(function (callable $get) {
                        $cycleId = $get('cycle_id');
                        if (!$cycleId) return null;

                        $cycle = Cycle::find($cycleId);
                        return $cycle?->end_date;
                    }),

                DatePicker::make('end_date')
                    ->required()
                    ->reactive()
                    ->minDate(function (callable $get) {
                        $cycleId = $get('cycle_id');
                        if (!$cycleId) return null;

                        $cycle = Cycle::find($cycleId);
                        return $get('start_date') ?? $cycle?->start_date;
                    })
                    ->maxDate(function (callable $get) {
                        $cycleId = $get('cycle_id');
                        if (!$cycleId) return null;

                        $cycle = Cycle::find($cycleId);
                        return $cycle?->end_date;
                    }),



            ]);
    }
}