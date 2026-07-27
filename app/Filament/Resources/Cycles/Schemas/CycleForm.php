<?php

namespace App\Filament\Resources\Cycles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CycleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                DatePicker::make('start_date')
                    ->required()
                    ->reactive(),
                DatePicker::make('end_date')
                    ->required()
                    ->reactive()
                    ->minDate(fn (callable $get) => $get('start_date')),
            ]);
    }
}
