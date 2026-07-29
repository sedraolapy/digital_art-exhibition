<?php

namespace App\Filament\Resources\LectureAttendances\Pages;

use App\Filament\Resources\LectureAttendances\LectureAttendanceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLectureAttendance extends EditRecord
{
    protected static string $resource = LectureAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
