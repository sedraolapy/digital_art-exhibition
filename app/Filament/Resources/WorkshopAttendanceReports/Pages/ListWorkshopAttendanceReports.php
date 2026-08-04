<?php

namespace App\Filament\Resources\WorkshopAttendanceReports\Pages;

use App\Filament\Resources\WorkshopAttendanceReports\WorkshopAttendanceReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkshopAttendanceReports extends ListRecords
{
    protected static string $resource = WorkshopAttendanceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
