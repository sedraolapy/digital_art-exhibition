<?php

namespace App\Filament\Resources\VotingResults\Pages;

use App\Filament\Resources\VotingResults\VotingResultResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVotingResults extends ListRecords
{
    protected static string $resource = VotingResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
