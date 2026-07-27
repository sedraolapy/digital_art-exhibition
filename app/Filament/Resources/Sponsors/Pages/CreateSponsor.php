<?php

namespace App\Filament\Resources\Sponsors\Pages;

use App\Filament\Resources\Sponsors\SponsorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSponsor extends CreateRecord
{
    protected static string $resource = SponsorResource::class;

    protected function afterCreate(): void
    {
        $this->record->cycles()->sync(
            $this->data['cycles'] ?? []
        );

        $this->record->occurrences()->sync(
            $this->data['occurrences'] ?? []
        );
    }
}
