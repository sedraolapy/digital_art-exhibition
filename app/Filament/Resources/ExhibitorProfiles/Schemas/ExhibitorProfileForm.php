<?php

namespace App\Filament\Resources\ExhibitorProfiles\Schemas;

use App\Enums\ExhibitorStatus;
use App\Models\EventOccurrence;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ExhibitorProfileForm
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


                TextInput::make('experience_years')
                    ->numeric()
                    ->required(),

                SpatieMediaLibraryFileUpload::make('cv_file')
                    ->collection('exhibitor_cv')
                    ->label('CV File')
                    ->openable()
                    ->required(),

                TextInput::make('portfolio_url')
                    ->url()
                    ->required(),

                Textarea::make('bio')
                    ->columnSpanFull()
                    ->required(),

                SpatieMediaLibraryFileUpload::make('image')
                    ->required()
                    ->collection('exhibitor_profile')
                    ->image()
                    ->maxSize(1024)
                    ->validationMessages([
                        'max' => 'The image size must not exceed 1 MB.',
                    ])
                    ->preserveFilenames(),
            ]);
    }
}
