<?php

namespace App\Filament\Resources\ExhibitorApplications\Schemas;

use App\Enums\ExhibitorStatus;
use App\Models\EventOccurrence;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ExhibitorApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship(
                        name: 'user',
                        titleAttribute: 'first_name',
                        modifyQueryUsing: fn ($query) => $query->orderBy('first_name')
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn (User $record): string => "{$record->first_name} {$record->last_name}"
                    )
                    ->searchable(['first_name', 'last_name', 'email'])
                    ->preload()
                    ->required(),

                Select::make('event_occurrences_id')
                    ->relationship(
                        name: 'eventOccurrence',
                        titleAttribute: 'id',
                        modifyQueryUsing: fn ($query) => $query->with('location')
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn (EventOccurrence $record): string => $record->location->name
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('status')
                    ->options(ExhibitorStatus::class)
                    ->required(),

                TextInput::make('experience_years')
                    ->numeric()
                    ->required(),

                FileUpload::make('cv_file')
                    ->directory('exhibitors/application/cv')
                    ->disk('public')
                    ->downloadable()
                    ->openable()
                    ->required(),

                TextInput::make('portfolio_url')
                    ->url()
                    ->required(),

                Textarea::make('bio')
                    ->columnSpanFull()
                    ->required(),

                FileUpload::make('image_url')
                    ->image()
                    ->directory('exhibitors/application/profiles')
                    ->disk('public')
                    ->required(),
            ]);
    }
}