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
                    ->formatStateUsing(fn ($state) => 'Visit'),
                ImageEntry::make('image_url')
                    ->placeholder('-')
                    ->label('Member Image')
                    ->circular()
                    ->height(150)
                    ->width(150)
                    ->getStateUsing(fn ($record) => $record->image_url ? asset('storage/'.$record->image_url) : null),
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
                            ->label('Platform'),

                        TextEntry::make('url')
                            ->label('Link')
                            ->url(fn ($state) => $state)
                            ->openUrlInNewTab(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
            ]);
    }
}
