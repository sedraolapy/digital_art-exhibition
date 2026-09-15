<?php

namespace App\Filament\Resources\Lectures\Schemas;

use Carbon\Carbon;
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
                TextEntry::make('speaker_name'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('image')
                    ->label('Image')
                    ->getStateUsing(fn ($record) =>$record->getMedia('lectures')->map(fn($media) => $media->getUrl()))
                    ->url(fn ($state) => $state)
                    ->openUrlInNewTab(),
                TextEntry::make('max_seats')
                    ->numeric()
                    ->badge(),
                TextEntry::make('day.day_number')
                    ->label('Event Day')
                    ->url(fn ($record) => route('filament.admin.resources.event-days.view', $record->day))
                    ->color('primary')
                    ->weight('medium')
                    ->icon('heroicon-o-link')
                    ->iconPosition('before'),
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('start_time')
                    ->time('H:i'),
                TextEntry::make('end_time')
                    ->time('H:i'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
