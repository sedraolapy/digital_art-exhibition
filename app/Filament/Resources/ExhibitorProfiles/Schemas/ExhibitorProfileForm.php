<?php

namespace App\Filament\Resources\ExhibitorProfiles\Schemas;

use App\Enums\RoleEnum;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Forms\Components\WebpMediaLibraryFileUpload;
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
                        modifyQueryUsing: fn ($query) => $query
                            ->whereHas('roles', function ($query) {
                                $query->where('name', RoleEnum::USER->value);
                            })
                            ->orderBy('first_name')
                    )
                    ->searchable(['first_name', 'last_name'])
                    ->preload()
                    ->required(),

                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('experience_years')
                    ->numeric()
                    ->minValue(0)
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
                Textarea::make('bio')
                    ->rows(5)
                    ->columnSpanFull()
                    ->required(),

                SpatieMediaLibraryFileUpload::make('cv_file')
                    ->label('CV')
                    ->required()
                    ->collection('exhibitor_cv')
                    ->openable(),

                WebpMediaLibraryFileUpload::make('image')
                    ->label('Image')
                    ->required()
                    ->collection('exhibitor_image')
                    ->image()
                    ->maxSize(1024)
                    ->imageCropAspectRatio('1:1')
                    ->imageEditor()
                    ->hint('The image must be square (1:1 ratio)')
                    ->validationMessages([
                        'max' => 'The image size must not exceed 1 MB.',
                    ]),
            ]);
    }
}