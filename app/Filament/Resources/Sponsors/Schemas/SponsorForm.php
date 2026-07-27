<?php

namespace App\Filament\Resources\Sponsors\Schemas;

use App\Enums\EventOccurrenceStatus;
use App\Enums\SponsorType;
use App\Models\EventOccurrence;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SponsorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                SpatieMediaLibraryFileUpload::make('logo_url')
                    ->label('Logo')
                    ->required()
                    ->collection('sponsors')
                    ->hint('Only SVG format')
                    ->acceptedFileTypes(['image/svg+xml'])
                    ->maxSize(1024)
                    ->validationMessages([
                        'max' => 'The image size must not exceed 1 MB.',
                        'accepted' => 'Only SVG files are allowed.',
                    ])
                    ->preserveFilenames(),

                Select::make('type')
                    ->label('Sponsor Type')
                    ->options([
                        SponsorType::DIAMOND->value => 'Diamond',
                        SponsorType::GOLD->value => 'Gold',
                        SponsorType::SILVER->value => 'Silver',
                    ])
                    ->required()
                    ->live(),

                Select::make('cycles')
                    ->label('Cycles')
                    ->relationship(
                        name: 'cycles',
                        titleAttribute: 'name'
                    )
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->required()
                    ->visible(fn ($get) =>
                        $get('type') === SponsorType::DIAMOND->value
                    ),

                Select::make('occurrences')
                    ->label('Event Occurrences')
                    ->relationship(
                        name: 'occurrences',
                        titleAttribute: 'title',
                        modifyQueryUsing: fn ($query) =>
                            $query
                                ->with('location')
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn (EventOccurrence $record) =>
                            "{$record->title} - {$record->location?->name}"
                    )
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->required()
                    ->visible(fn ($get) =>
                        in_array($get('type'), [
                            SponsorType::GOLD->value,
                            SponsorType::SILVER->value,
                        ])
                    ),
            ]);
    }
}