<?php

namespace App\Filament\Resources\ExhibitorApplications\Pages;

use App\Filament\Resources\ExhibitorApplications\ExhibitorApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditExhibitorApplication extends EditRecord
{
    protected static string $resource = ExhibitorApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $links = [
            'instagram' => $this->data['instagram'] ?? null,
            'facebook' => $this->data['facebook'] ?? null,
            'linkedin' => $this->data['linkedin'] ?? null,
            'behance' => $this->data['behance'] ?? null,
        ];

        foreach ($links as $platform => $url) {
            if ($url) {
                $this->record->socialLinks()->updateOrCreate(
                    ['platform' => $platform],
                    ['url' => $url]
                );
            } else {
                $this->record->socialLinks()
                    ->where('platform', $platform)
                    ->delete();
            }
        }
    }
}
