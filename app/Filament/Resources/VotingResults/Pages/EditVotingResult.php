<?php

namespace App\Filament\Resources\VotingResults\Pages;

use App\Filament\Resources\VotingResults\VotingResultResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditVotingResult extends EditRecord
{
    protected static string $resource = VotingResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
