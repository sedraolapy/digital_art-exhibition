<?php

namespace App\Filament\Resources\EventOccurrences\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EventOccurrenceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('cycle.name')
                    ->label('Cycle'),
                TextEntry::make('location.name')
                    ->label('Location'),
                TextEntry::make('start_date')
                    ->date(),
                TextEntry::make('end_date')
                    ->date(),
                IconEntry::make('is_voting_enabled')
                    ->boolean(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                RepeatableEntry::make('days')
                    ->schema([
                        TextEntry::make('day_number'),
                        TextEntry::make('date')
                            ->date(),
                    ]),
            ]);
    }
}
