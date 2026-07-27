<?php

namespace App\Filament\Resources\Experiences\Schemas;

use App\Enums\ExperienceStatus;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ExperienceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        ExperienceStatus::DRAFT => 'secondary',
                        ExperienceStatus::PUBLISHED => 'primary',
                        ExperienceStatus::ARCHIVED => 'danger',
                    }),
                TextEntry::make('start_date')
                    ->date(),
                TextEntry::make('end_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                RepeatableEntry::make('gallery')
                    ->label('Gallery')
                    ->getStateUsing(fn ($record) =>
                        $record->getMedia('experience_gallery')
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
                    ->grid(2),
            ]);
    }
}
