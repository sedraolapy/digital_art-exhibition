<?php

namespace App\Filament\Resources\EventOccurrences\Pages;

use App\Filament\Resources\EventOccurrences\EventOccurrenceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventOccurrences extends ListRecords
{
    protected static string $resource = EventOccurrenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
