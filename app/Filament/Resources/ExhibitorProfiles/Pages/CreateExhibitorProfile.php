<?php

namespace App\Filament\Resources\ExhibitorProfiles\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\ExhibitorProfiles\ExhibitorProfileResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExhibitorProfile extends CreateRecord
{
    protected static string $resource = ExhibitorProfileResource::class;

    protected function afterCreate(): void
    {
        $this->record->user->syncRoles(
            RoleEnum::EXHIBITOR->value
        );
    }
}
