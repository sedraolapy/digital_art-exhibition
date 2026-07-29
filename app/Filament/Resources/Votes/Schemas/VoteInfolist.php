<?php

namespace App\Filament\Resources\Votes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VoteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User name')
                    ->url(fn ($record) => route('filament.admin.resources.users.view', $record->user))
                    ->color('primary')
                    ->weight('medium')
                    ->icon('heroicon-o-link')
                    ->iconPosition('before'),
                TextEntry::make('exhibitor.user.name')
                    ->label('Exhibitor name')
                    ->url(fn ($record) => route('filament.admin.resources.exhibitor-profiles.view',$record->exhibitor))
                    ->color('primary')
                    ->weight('medium')
                    ->icon('heroicon-o-link')
                    ->iconPosition('before'),
                TextEntry::make('eventOccurrence.title')
                    ->label('Event occurrence'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
