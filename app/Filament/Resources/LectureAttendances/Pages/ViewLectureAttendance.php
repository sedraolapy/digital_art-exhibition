<?php

namespace App\Filament\Resources\LectureAttendances\Pages;

use App\Filament\Resources\LectureAttendances\LectureAttendanceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLectureAttendance extends ViewRecord
{
    protected static string $resource = LectureAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
