<?php

namespace App\Filament\Resources\EventDays\Pages;

use App\Filament\Resources\EventDays\EventDayResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEventDay extends EditRecord
{
    protected static string $resource = EventDayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
