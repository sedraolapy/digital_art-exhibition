<?php

namespace App\Filament\Resources\Sponsors\Pages;

use App\Filament\Resources\Sponsors\SponsorResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSponsor extends EditRecord
{
    protected static string $resource = SponsorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $sponsor = $this->getRecord();

        $data['cycle_id'] = $sponsor->cycles()->value('cycles.id');
        $data['event_occurrence_id'] = $sponsor->occurrences()->value('event_occurrences.id');

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->cycles()->sync(
            $this->data['cycles'] ?? []
        );

        $this->record->occurrences()->sync(
            $this->data['occurrences'] ?? []
        );
    }
}
