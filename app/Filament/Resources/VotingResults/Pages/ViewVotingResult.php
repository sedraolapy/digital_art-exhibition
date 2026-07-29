<?php

namespace App\Filament\Resources\VotingResults\Pages;

use App\Filament\Resources\VotingResults\VotingResultResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewVotingResult extends ViewRecord
{
    protected static string $resource = VotingResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
