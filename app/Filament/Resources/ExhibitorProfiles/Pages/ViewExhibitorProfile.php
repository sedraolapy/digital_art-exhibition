<?php

namespace App\Filament\Resources\ExhibitorProfiles\Pages;

use App\Filament\Resources\ExhibitorProfiles\ExhibitorProfileResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewExhibitorProfile extends ViewRecord
{
    protected static string $resource = ExhibitorProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
