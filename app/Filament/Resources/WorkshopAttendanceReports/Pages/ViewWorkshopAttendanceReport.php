<?php

namespace App\Filament\Resources\WorkshopAttendanceReports\Pages;

use App\Filament\Resources\WorkshopAttendanceReports\WorkshopAttendanceReportResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWorkshopAttendanceReport extends ViewRecord
{
    protected static string $resource = WorkshopAttendanceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
