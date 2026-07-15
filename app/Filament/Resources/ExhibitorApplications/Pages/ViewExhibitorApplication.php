<?php

namespace App\Filament\Resources\ExhibitorApplications\Pages;

use App\Filament\Resources\ExhibitorApplications\ExhibitorApplicationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewExhibitorApplication extends ViewRecord
{
    protected static string $resource = ExhibitorApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
