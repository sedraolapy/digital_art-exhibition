<?php

namespace App\Filament\Resources\ExhibitorApplications\Schemas;

use App\Enums\EventOccurrenceStatus;
use App\Enums\ExhibitorStatus;
use App\Enums\RoleEnum;
use App\Models\EventOccurrence;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
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
                        modifyQueryUsing: fn ($query) => $query
                            ->whereHas('roles', function ($query) {
                                $query->where('name', RoleEnum::USER->value);
                            })
                            ->orderBy('first_name')
                    )
                    ->searchable(['first_name', 'last_name'])
                    ->preload()
                    ->required(),

                Textarea::make('bio')
                    ->columnSpanFull()
                    ->required(),

                Select::make('event_occurrence_id')
                    ->relationship(
                        name: 'eventOccurrence',
                        titleAttribute: 'id',
                        modifyQueryUsing: fn ($query) =>
                            $query->where('status', EventOccurrenceStatus::ACTIVE->value)
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn (EventOccurrence $record): string => $record->title
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
                    ->default(ExhibitorStatus::PENDING->value)
                    ->required(),

                TextInput::make('experience_years')
                    ->numeric()
                    ->required(),

                TextInput::make('portfolio_url')
                    ->label('Portfolio')
                    ->url()
                    ->required(),

                TextInput::make('instagram')
                    ->label('Instagram')
                    ->url()
                    ->required()
                    ->dehydrated(false)
                    ->afterStateHydrated(function ($component, $record) {
                        $component->state(
                            $record?->socialLinks
                                ->firstWhere('platform', 'instagram')
                                ?->url
                        );
                    }),
                
                TextInput::make('facebook')
                    ->label('Facebook')
                    ->url()
                    ->required()
                    ->dehydrated(false)
                    ->afterStateHydrated(function ($component, $record) {
                        $component->state(
                            $record?->socialLinks
                                ->firstWhere('platform', 'facebook')
                                ?->url
                        );
                    }),
                
                TextInput::make('linkedin')
                    ->label('LinkedIn')
                    ->url()
                    ->nullable()
                    ->dehydrated(false)
                    ->afterStateHydrated(function ($component, $record) {
                        $component->state(
                            $record?->socialLinks
                                ->firstWhere('platform', 'linkedin')
                                ?->url
                        );
                    }),
                
                TextInput::make('behance')
                    ->label('Behance')
                    ->url()
                    ->nullable()
                    ->dehydrated(false)
                    ->afterStateHydrated(function ($component, $record) {
                        $component->state(
                            $record?->socialLinks
                                ->firstWhere('platform', 'behance')
                                ?->url
                        );
                    }),

                SpatieMediaLibraryFileUpload::make('cv_file')
                    ->collection('application_cv')
                    ->label('CV File')
                    ->rules([
                        'file',
                        'mimes:pdf,doc,docx',
                    ])
                    ->openable()
                    ->required(),

                SpatieMediaLibraryFileUpload::make('image')
                    ->required()
                    ->collection('application_image')
                    ->image()
                    ->maxSize(1024)
                    ->imageCropAspectRatio('1:1')
                    ->imageEditor()
                    ->hint('The image must be square (1:1 ratio)')
                    ->validationMessages([
                        'max' => 'The image size must not exceed 1 MB.',
                    ])
                    ->preserveFilenames(),
            ]);
    }
}