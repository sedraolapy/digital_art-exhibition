<?php

namespace App\Filament\Resources\ExhibitorProfiles\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\ExhibitorProfiles\ExhibitorProfileResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExhibitorProfile extends CreateRecord
{
    protected static string $resource = ExhibitorProfileResource::class;

    protected function afterCreate(): void
    {
        $this->record->user->syncRoles(
            RoleEnum::EXHIBITOR->value
        );
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
