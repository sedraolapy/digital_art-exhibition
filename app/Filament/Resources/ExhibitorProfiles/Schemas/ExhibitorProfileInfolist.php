<?php

namespace App\Filament\Resources\ExhibitorProfiles\Schemas;

use App\Enums\RoleEnum;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ExhibitorProfileInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User')
                    ->url(fn ($record) => route(
                        'filament.admin.resources.users.view',
                        $record->user
                    ))
                    ->openUrlInNewTab(false)
                    ->color('primary')
                    ->weight('medium')
                    ->icon('heroicon-o-link')
                    ->iconPosition('before'),
                ImageEntry::make('image')
                    ->label('Image')
                    ->circular()
                    ->size(150)
                    ->state(function ($record) {

                        $collection = $record->user->hasRole(RoleEnum::EXHIBITOR->value)
                            ? 'exhibitor_image'
                            : null;

                        return $record->user->getFirstMediaUrl($collection, 'webp')
                            ?: null;
                    })
                    ->url(fn ($state) => $state)
                    ->openUrlInNewTab(),
                TextEntry::make('eventOccurrence.title')
                    ->label('Event occurrence'),
                TextEntry::make('category.name')
                    ->label('Category'),
                TextEntry::make('experience_years')
                    ->numeric(),
                TextEntry::make('user.email')
                    ->label('Email'),
                TextEntry::make('user.phone')
                    ->label('Phone number'),
                TextEntry::make('bio')
                    ->columnSpanFull(),
                TextEntry::make('cv_file')
                    ->label('CV File')
                    ->getStateUsing(fn ($record) =>
                        $record->getMedia('exhibitor_cv')
                            ->map(fn($media) => '<a href="'.$media->getUrl().'" target="_blank" download>📄 Download CV</a>')
                            ->implode('<br>')
                    )
                    ->html(),
                TextEntry::make('portfolio_url')
                    ->label('Portfolio')
                    ->url(fn ($state) => $state)
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn () => 'Visit Portfolio')
                    ->color('primary')
                    ->weight('medium')
                    ->icon('heroicon-o-link')
                    ->iconPosition('before'),
                RepeatableEntry::make('user.socialLinks')
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
