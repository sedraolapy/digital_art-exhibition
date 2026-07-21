<?php

namespace App\Filament\Resources\EventDays\Pages;

use App\Filament\Resources\EventDays\EventDayResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEventDay extends ViewRecord
{
    protected static string $resource = EventDayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
