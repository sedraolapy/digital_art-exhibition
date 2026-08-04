<?php

namespace App\Filament\Resources\Workshops\Schemas;

use App\Enums\WorkshopStatus;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class WorkshopInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                ImageEntry::make('image')
                    ->label('Image')
                    ->getStateUsing(fn ($record) =>$record->getMedia('workshops')->map(fn($media) => $media->getUrl('webp')))
                    ->url(fn ($state) => $state)
                    ->openUrlInNewTab(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('speaker_name'),
                TextEntry::make('max_seats')
                    ->numeric(),
                TextEntry::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        WorkshopStatus::UPCOMING => 'warning',
                        WorkshopStatus::ACTIVE => 'success',
                        WorkshopStatus::FINISHED => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => $state->value),
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('start_time')
                    ->time('H:i'),
                TextEntry::make('end_time')
                    ->time('H:i'),
                RepeatableEntry::make('gallery')
                    ->label('Gallery')
                    ->getStateUsing(fn ($record) =>
                        $record->getMedia('workshop_gallery')
                            ->map(fn ($media) => [
                                'image' => $media->getUrl('webp'),
                            ])
                            ->toArray()
                    )
                    ->schema([
                        ImageEntry::make('image')
                            ->hiddenLabel()
                            ->url(fn ($state) => $state)
                            ->openUrlInNewTab(),
                    ])
                    ->grid(2)
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
