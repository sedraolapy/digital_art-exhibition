<?php

namespace App\Filament\Resources\EventOccurrences\Pages;

use App\Filament\Resources\EventOccurrences\EventOccurrenceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEventOccurrence extends EditRecord
{
    protected static string $resource = EventOccurrenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
