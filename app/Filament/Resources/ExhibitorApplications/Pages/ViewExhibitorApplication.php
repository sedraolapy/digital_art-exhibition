<?php

namespace App\Filament\Resources\ExhibitorApplications\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\ExhibitorApplications\ExhibitorApplicationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

class ViewExhibitorApplication extends ViewRecord
{
    protected static string $resource = ExhibitorApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->visible(fn () => Auth::user()->hasRole(RoleEnum::SUPER_ADMIN->value)),
        ];
    }
}
