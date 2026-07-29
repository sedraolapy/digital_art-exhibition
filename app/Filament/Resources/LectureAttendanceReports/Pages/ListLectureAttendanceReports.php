<?php

namespace App\Filament\Resources\LectureAttendanceReports\Pages;

use App\Filament\Resources\LectureAttendanceReports\LectureAttendanceReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLectureAttendanceReports extends ListRecords
{
    protected static string $resource = LectureAttendanceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
