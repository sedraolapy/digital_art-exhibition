<?php

namespace App\Filament\Resources\ExhibitorApplications\Schemas;

use App\Enums\ExhibitorStatus;
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
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (ExhibitorStatus $state) => match ($state) {
                        ExhibitorStatus::PENDING => 'Pending',
                        ExhibitorStatus::REJECTED => 'Rejected',
                        ExhibitorStatus::APPROVED_INITIAL => 'Approved (Initial)',
                        ExhibitorStatus::APPROVED_FINAL => 'Approved (Final)',
                    })
                    ->color(fn (ExhibitorStatus $state) => match ($state) {
                        ExhibitorStatus::PENDING => 'warning',
                        ExhibitorStatus::REJECTED => 'danger',
                        ExhibitorStatus::APPROVED_INITIAL => 'info',
                        ExhibitorStatus::APPROVED_FINAL => 'success',
                    }),
                TextEntry::make('bio')
                    ->columnSpanFull(),
                TextEntry::make('experience_years')
                    ->numeric(),
                TextEntry::make('cv_file')
                    ->label('CV File')
                    ->getStateUsing(fn ($record) =>
                        $record->getMedia('application_cv')
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
                ImageEntry::make('image')
                    ->label('Image')
                    ->getStateUsing(fn ($record) =>
                        $record->getMedia('application_image')
                            ->map(fn($media) => $media->getUrl('webp'))
                    )
                    ->height(200)
                    ->width(200),
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
