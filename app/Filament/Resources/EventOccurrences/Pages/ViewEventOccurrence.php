<?php

namespace App\Filament\Resources\EventOccurrences\Pages;

use App\Filament\Resources\EventOccurrences\EventOccurrenceResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEventOccurrence extends ViewRecord
{
    protected static string $resource = EventOccurrenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
