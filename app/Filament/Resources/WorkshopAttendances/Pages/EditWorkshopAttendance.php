<?php

namespace App\Filament\Resources\WorkshopAttendances\Pages;

use App\Filament\Resources\WorkshopAttendances\WorkshopAttendanceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditWorkshopAttendance extends EditRecord
{
    protected static string $resource = WorkshopAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
