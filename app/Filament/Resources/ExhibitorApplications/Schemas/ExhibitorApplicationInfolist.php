<?php

namespace App\Filament\Resources\ExhibitorApplications\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Infolists\Components\RepeatableEntry;

class ExhibitorApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name'),
                TextEntry::make('user.email'),
                TextEntry::make('user.phone'),
                TextEntry::make('eventOccurrence.location.name')
                    ->label('Event occurrence location'),
                TextEntry::make('category.name')
                ->label('Category')
                    ->numeric(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('bio')
                    ->columnSpanFull(),
                TextEntry::make('experience_years')
                    ->numeric(),
                TextEntry::make('cv_file')
                    ->label('CV File')
                    ->formatStateUsing(fn ($state) => '📄 Download CV')
                    ->url(fn ($state) => asset('storage/' . $state)),
                TextEntry::make('portfolio_url')
                    ->label('Portfolio')
                    ->url(fn ($state) => $state)
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn ($state) => 'Visit'),
                ImageEntry::make('image_url')
                    ->label('Profile Image')
                    ->getStateUsing(fn ($record) => $record->image_url ? asset('storage/'.$record->image_url) : null)
                    ->height(100)
                    ->width(100),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                RepeatableEntry::make('socialLinks')
                    ->schema([
                        TextEntry::make('platform')
                            ->label('')
                            ->formatStateUsing(fn ($state) => ucfirst($state)),
                        TextEntry::make('url')
                            ->label('')
                            ->url(fn ($state) => $state)
                            ->openUrlInNewTab()
                            ->formatStateUsing(fn ($state) => 'Visit'),
                    ])
                    ->label('Social Links')
                    ->columns(2) 
                    ->columnSpanFull(),
            ]);
    }
}
