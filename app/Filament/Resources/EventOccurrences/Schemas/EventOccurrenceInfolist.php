<?php

namespace App\Filament\Resources\EventOccurrences\Schemas;

use App\Enums\EventOccurrenceStatus;
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
                IconEntry::make('is_voting_enabled')
                    ->boolean(),
                TextEntry::make('start_date')
                    ->date(),
                TextEntry::make('end_date')
                    ->date(),
                TextEntry::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        EventOccurrenceStatus::UPCOMING => 'warning',
                        EventOccurrenceStatus::ACTIVE => 'success',
                        EventOccurrenceStatus::FINISHED => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => $state->value)
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
