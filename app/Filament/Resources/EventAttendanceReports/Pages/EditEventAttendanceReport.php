<?php

namespace App\Filament\Resources\EventAttendanceReports\Pages;

use App\Filament\Resources\EventAttendanceReports\EventAttendanceReportResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEventAttendanceReport extends EditRecord
{
    protected static string $resource = EventAttendanceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }
}
