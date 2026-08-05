<?php

namespace App\Filament\Resources\Statistics\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\Statistics\StatisticResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListStatistics extends ListRecords
{
    protected static string $resource = StatisticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn () => Auth::user()->hasRole(RoleEnum::SUPER_ADMIN->value)),
        ];
    }
}
