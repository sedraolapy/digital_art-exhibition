<?php

namespace App\Filament\Resources\EventAttendanceReports\Pages;

use App\Filament\Resources\EventAttendanceReports\EventAttendanceReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventAttendanceReports extends ListRecords
{
    protected static string $resource = EventAttendanceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
      //
        ];
    }
}
