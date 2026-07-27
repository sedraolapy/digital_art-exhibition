<?php

namespace App\Filament\Resources\Sponsors\Schemas;

use App\Filament\Resources\Cycles\CycleResource;
use App\Filament\Resources\EventOccurrences\EventOccurrenceResource;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SponsorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),

                ImageEntry::make('logo')
                    ->label('Logo')
                    ->getStateUsing(fn ($record) =>
                        $record->getFirstMediaUrl('sponsors')
                    )
                    ->height(60),

                TextEntry::make('type')
                    ->badge()
                    ->formatStateUsing(fn ($state) =>
                        ucfirst($state->value)
                    ),

                    RepeatableEntry::make('cycles')
                    ->label('Cycles')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Cycle Name')
                            ->url(fn ($record) =>
                                CycleResource::getUrl(
                                    'view',
                                    ['record' => $record]
                                )
                            )
                            ->color('primary')
                            ->weight('medium')
                            ->icon('heroicon-o-link')
                            ->iconPosition('before'),
                    ])
                    ->columnSpanFull(),

                RepeatableEntry::make('occurrences')
                    ->label('Event Occurrences')
                    ->schema([
                        TextEntry::make('title')
                            ->label('Title')
                            ->url(fn ($record) =>
                                EventOccurrenceResource::getUrl(
                                    'view',
                                    ['record' => $record]
                                )
                            )
                            ->color('primary')
                            ->weight('medium')
                            ->icon('heroicon-o-link')
                            ->iconPosition('before'),

                        TextEntry::make('location.name')
                            ->label('Location'),

                        TextEntry::make('start_date')
                            ->label('Start Date')
                            ->date(),

                        TextEntry::make('end_date')
                            ->label('End Date')
                            ->date()
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->visible(fn ($record) =>
                        $record->occurrences->isNotEmpty()
                    )
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