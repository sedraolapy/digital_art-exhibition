<?php

namespace App\Filament\Resources\LectureAttendances\Pages;

use App\Filament\Resources\LectureAttendances\LectureAttendanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLectureAttendances extends ListRecords
{
    protected static string $resource = LectureAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
