<?php

namespace App\Filament\Resources\Sponsors\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SponsorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                ImageEntry::make('logo_url')
                    ->circular()
                    ->label('Logo')
                    ->height(150)
                    ->width(150)
                    ->getStateUsing(fn ($record) => $record->logo_url ? asset('storage/'.$record->logo_url) : null),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
