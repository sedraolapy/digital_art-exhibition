<?php

namespace App\Filament\Resources\WorkshopAttendances\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WorkshopAttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('workshop_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
