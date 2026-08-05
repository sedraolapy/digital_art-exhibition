<?php

namespace App\Filament\Resources\Sponsors\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\Sponsors\SponsorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListSponsors extends ListRecords
{
    protected static string $resource = SponsorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () => Auth::user()->hasRole(RoleEnum::SUPER_ADMIN->value)),
        ];
    }
}
