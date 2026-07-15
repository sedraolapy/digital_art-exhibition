<?php

namespace App\Filament\Resources\ExhibitorProfiles\Pages;

use App\Filament\Resources\ExhibitorProfiles\ExhibitorProfileResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditExhibitorProfile extends EditRecord
{
    protected static string $resource = ExhibitorProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
