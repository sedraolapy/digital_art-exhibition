<?php

namespace App\Filament\Resources\LectureAttendanceReports\Pages;

use App\Filament\Resources\LectureAttendanceReports\LectureAttendanceReportResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLectureAttendanceReport extends ViewRecord
{
    protected static string $resource = LectureAttendanceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
