<?php

namespace App\Filament\Resources\EventDays\Pages;

use App\Filament\Resources\EventDays\EventDayResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventDays extends ListRecords
{
    protected static string $resource = EventDayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
