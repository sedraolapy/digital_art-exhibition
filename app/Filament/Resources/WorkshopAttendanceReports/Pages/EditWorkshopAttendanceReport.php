<?php

namespace App\Filament\Resources\WorkshopAttendanceReports\Pages;

use App\Filament\Resources\WorkshopAttendanceReports\WorkshopAttendanceReportResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditWorkshopAttendanceReport extends EditRecord
{
    protected static string $resource = WorkshopAttendanceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
