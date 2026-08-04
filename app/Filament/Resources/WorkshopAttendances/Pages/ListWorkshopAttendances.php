<?php

namespace App\Filament\Resources\WorkshopAttendances\Pages;

use App\Filament\Resources\WorkshopAttendances\WorkshopAttendanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkshopAttendances extends ListRecords
{
    protected static string $resource = WorkshopAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
