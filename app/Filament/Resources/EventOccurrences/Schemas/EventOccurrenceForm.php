<?php

namespace App\Filament\Resources\EventOccurrences\Schemas;

use App\Models\Cycle;
use App\Models\Location;
use Filament\Forms\Components\DatePicker;
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
                    ->required(),

                DatePicker::make('end_date')
                    ->required()
                    ->afterOrEqual('start_date'),
            ]);
    }
}