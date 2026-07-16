<?php

namespace App\Filament\Resources\Sponsors\Schemas;

use App\Enums\EventOccurrenceStatus;
use App\Enums\SponsorType;
use App\Models\Cycle;
use App\Models\EventOccurrence;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
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
                FileUpload::make('logo_url')
                    ->required()
                    ->disk('public')
                    ->directory('sponsors')
                    ->image(),
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
                    ->options(Cycle::pluck('name', 'id'))
                    ->visible(fn ($get) => $get('type') === SponsorType::DIAMOND->value)
                    ->reactive(),

                Select::make('event_occurrence_id')
                    ->label('Occurrence')
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
