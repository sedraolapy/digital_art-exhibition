<?php

namespace App\Filament\Resources\VotingResults\Pages;

use App\Filament\Resources\VotingResults\VotingResultResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVotingResult extends CreateRecord
{
    protected static string $resource = VotingResultResource::class;
}
