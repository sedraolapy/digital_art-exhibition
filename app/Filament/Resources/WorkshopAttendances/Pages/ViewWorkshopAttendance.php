<?php

namespace App\Filament\Resources\WorkshopAttendances\Pages;

use App\Filament\Resources\WorkshopAttendances\WorkshopAttendanceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWorkshopAttendance extends ViewRecord
{
    protected static string $resource = WorkshopAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
