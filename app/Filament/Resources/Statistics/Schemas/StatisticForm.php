<?php

namespace App\Filament\Resources\Statistics\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StatisticForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('value')
                    ->required()
                    ->numeric(),
            ]);
    }
}
