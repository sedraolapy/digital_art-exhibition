<?php

namespace App\Filament\Resources\Locations\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LocationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                RepeatableEntry::make('occurrences')
                    ->label('Event Occurrences')
                    ->schema([
                        TextEntry::make('title')
                            ->label('Title')
                            ->url(fn ($record) => route('filament.admin.resources.event-occurrences.view', $record))
                            ->color('primary')
                            ->weight('medium')
                            ->icon('heroicon-o-link')
                            ->iconPosition('before'),
                    ])
                    ->columns(1)
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
