<?php

namespace App\Filament\Resources\Cycles\Schemas;

use App\Enums\CycleStatus;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\Entry;

class CycleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        CycleStatus::UPCOMING => 'warning',
                        CycleStatus::ACTIVE => 'success',
                        CycleStatus::FINISHED => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => $state->value),
                TextEntry::make('start_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('end_date')
                    ->date()
                    ->placeholder('-'),
                RepeatableEntry::make('occurrences')
                    ->schema([
                        TextEntry::make('title')
                            ->label('Event Title')
                            ->url(fn ($record) => route('filament.admin.resources.event-occurrences.view', $record))
                            ->color('primary')
                            ->weight('medium')
                            ->icon('heroicon-o-link')
                            ->iconPosition('before'),
                        TextEntry::make('start_date')->date()->label('Start'),
                        TextEntry::make('end_date')->date()->label('End'),
                    ])
                    ->columnSpanFull()
                    ->label('Events'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
