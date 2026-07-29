<?php

namespace App\Filament\Resources\LectureAttendanceReports\Pages;

use App\Filament\Resources\LectureAttendanceReports\LectureAttendanceReportResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLectureAttendanceReport extends EditRecord
{
    protected static string $resource = LectureAttendanceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
