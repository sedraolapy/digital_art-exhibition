<?php

namespace App\Filament\Resources\Lectures\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LectureInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('speaker_name'),
                TextEntry::make('max_seats')
                    ->numeric(),
                TextEntry::make('day.day_number')
                    ->label('Event day'),
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('start_time')
                    ->time(),
                TextEntry::make('end_time')
                    ->time(),
                ImageEntry::make('image')
                    ->label('Image')
                    ->getStateUsing(fn ($record) =>
                        $record->getMedia('lectures')
                            ->map(fn($media) => $media->getUrl('webp'))
                    )
                    ->height(200)
                    ->width(200),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
