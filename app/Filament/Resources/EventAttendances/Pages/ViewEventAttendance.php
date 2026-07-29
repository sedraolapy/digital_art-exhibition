<?php

namespace App\Filament\Resources\EventAttendances\Pages;

use App\Filament\Resources\EventAttendances\EventAttendanceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEventAttendance extends ViewRecord
{
    protected static string $resource = EventAttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
