<?php

namespace App\Filament\Resources\ExhibitorProfiles\Schemas;

use App\Enums\RoleEnum;
use Filament\Forms\Components\Repeater;
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

                Textarea::make('bio')
                    ->rows(5)
                    ->columnSpanFull()
                    ->required(),

                SpatieMediaLibraryFileUpload::make('cv_file')
                    ->label('CV')
                    ->required()
                    ->collection('exhibitor_cv')
                    ->openable(),
            ]);
    }
}