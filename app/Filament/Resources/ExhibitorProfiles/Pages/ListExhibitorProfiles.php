<?php

namespace App\Filament\Resources\ExhibitorProfiles\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\ExhibitorProfiles\ExhibitorProfileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListExhibitorProfiles extends ListRecords
{
    protected static string $resource = ExhibitorProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () => Auth::user()->hasRole(RoleEnum::SUPER_ADMIN->value)),
        ];
    }
}
