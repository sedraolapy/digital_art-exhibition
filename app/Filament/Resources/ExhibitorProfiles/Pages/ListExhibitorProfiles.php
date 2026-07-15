<?php

namespace App\Filament\Resources\ExhibitorProfiles\Pages;

use App\Filament\Resources\ExhibitorProfiles\ExhibitorProfileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExhibitorProfiles extends ListRecords
{
    protected static string $resource = ExhibitorProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
