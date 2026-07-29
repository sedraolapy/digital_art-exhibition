<?php

namespace App\Filament\Resources\EventAttendanceReports\Pages;

use App\Filament\Resources\EventAttendanceReports\EventAttendanceReportResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEventAttendanceReport extends ViewRecord
{
    protected static string $resource = EventAttendanceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
           //
        ];
    }

    
}
