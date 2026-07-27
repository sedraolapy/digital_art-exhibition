<?php

namespace App\Filament\Resources\Members\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Schemas\Schema;

class MemberInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('role'),
                TextEntry::make('bio')
                    ->columnSpanFull(),
                TextEntry::make('portfolio_url')
                    ->label('Portfolio')
                    ->url(fn ($state) => $state)
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn () => 'Visit Portfolio')
                    ->color('primary')
                    ->icon('heroicon-o-link'),
                RepeatableEntry::make('image')
                    ->label('Image')
                    ->getStateUsing(fn ($record) =>
                        $record->getMedia('members')
                            ->map(fn ($media) => [
                                'image' => $media->getUrl('webp'),
                            ])
                            ->toArray()
                    )
                    ->schema([
                        ImageEntry::make('image')
                            ->hiddenLabel()
                            ->height(200)
                            ->width(200)
                            ->url(fn ($state) => $state)
                            ->openUrlInNewTab(),
                    ])
                    ->grid(2),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                RepeatableEntry::make('socialLinks')
                    ->label('Social Links')
                    ->schema([
                        TextEntry::make('platform')
                            ->label('Platform')
                            ->badge(),

                        TextEntry::make('url')
                            ->label('Link')
                            ->url(fn ($state) => $state)
                            ->openUrlInNewTab()
                            ->formatStateUsing(fn () => 'Visit Profile')
                            ->icon('heroicon-o-link'),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
            ]);
    }
}
