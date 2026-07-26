<?php

namespace App\Filament\Resources\Sponsors\Schemas;

use App\Enums\EventOccurrenceStatus;
use App\Enums\SponsorType;
use App\Models\Cycle;
use App\Models\EventOccurrence;
use Filament\Forms\Components\FileUpload;
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
                    ->required()
                    ->collection('sponsors')
                    ->hint('only svg format')
                    ->acceptedFileTypes(['image/svg+xml'])
                    ->maxSize(1024)
                    ->validationMessages([
                        'max' => 'The image size must not exceed 1 MB.',
                        'accepted' => 'Only SVG files are allowed.',
                    ])
                    ->preserveFilenames(),
                Select::make('type')
                    ->options([
                        SponsorType::DIAMOND->value => 'Diamond',
                        SponsorType::GOLD->value    => 'Gold',
                        SponsorType::SILVER->value  => 'Silver',
                    ])
                    ->required()
                    ->reactive(),

                Select::make('cycle_id')
                    ->label('Cycle')
                    ->required()
                    ->options(Cycle::pluck('name', 'id'))
                    ->visible(fn ($get) => $get('type') === SponsorType::DIAMOND->value)
                    ->reactive(),

                Select::make('event_occurrence_id')
                    ->label('Occurrence')
                    ->required()
                    ->options(
                        EventOccurrence::where('status', EventOccurrenceStatus::ACTIVE->value)->with('location')
                            ->get()
                            ->mapWithKeys(fn ($occurrence) => [
                                $occurrence->id => $occurrence->location?->name,
                            ])
                    )
                    ->visible(fn ($get) => in_array($get('type'), [
                        SponsorType::GOLD->value,
                        SponsorType::SILVER->value,
                    ]))
                    ->reactive(),
            ]);
    }
}
