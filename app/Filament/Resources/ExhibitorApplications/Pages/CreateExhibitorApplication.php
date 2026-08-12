<?php

namespace App\Filament\Resources\ExhibitorApplications\Pages;

use App\Filament\Resources\ExhibitorApplications\ExhibitorApplicationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExhibitorApplication extends CreateRecord
{
    protected static string $resource = ExhibitorApplicationResource::class;

    protected array $socialLinks = [];

    protected function afterCreate(): void
    {
        $this->saveSocialLinks($this->record);
    }

    private function saveSocialLinks($application): void
    {
        $links = [
            'instagram' => $this->data['instagram'] ?? null,
            'facebook' => $this->data['facebook'] ?? null,
            'linkedin' => $this->data['linkedin'] ?? null,
            'behance' => $this->data['behance'] ?? null,
    ];

        foreach ($links as $platform => $url) {
            if ($url) {
                $application->socialLinks()->updateOrCreate(
                    ['platform' => $platform],
                    ['url' => $url]
                );
            }
        }
    }
}