<?php

namespace App\Filament\Resources\EventAttendances\Pages;

use App\Filament\Resources\EventAttendances\EventAttendanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventAttendances extends ListRecords
{
    protected static string $resource = EventAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
