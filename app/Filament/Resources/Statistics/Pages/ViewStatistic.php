<?php

namespace App\Filament\Resources\Statistics\Pages;

use App\Filament\Resources\Statistics\StatisticResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStatistic extends ViewRecord
{
    protected static string $resource = StatisticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
