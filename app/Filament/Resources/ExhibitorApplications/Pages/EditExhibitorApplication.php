<?php

namespace App\Filament\Resources\ExhibitorApplications\Pages;

use App\Filament\Resources\ExhibitorApplications\ExhibitorApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditExhibitorApplication extends EditRecord
{
    protected static string $resource = ExhibitorApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
