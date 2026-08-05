<?php

namespace App\Filament\Resources\Workshops\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\Workshops\WorkshopResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListWorkshops extends ListRecords
{
    protected static string $resource = WorkshopResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () => Auth::user()->hasRole(RoleEnum::SUPER_ADMIN->value)),
        ];
    }
}
