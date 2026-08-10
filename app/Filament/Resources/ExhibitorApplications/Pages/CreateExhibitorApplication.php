<?php

namespace App\Filament\Resources\ExhibitorApplications\Pages;

use App\Filament\Resources\ExhibitorApplications\ExhibitorApplicationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExhibitorApplication extends CreateRecord
{
    protected static string $resource = ExhibitorApplicationResource::class;

    protected array $socialLinks = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->socialLinks = [
            'instagram' => $data['instagram'] ?? null,
            'facebook'  => $data['facebook'] ?? null,
            'linkedin'  => $data['linkedin'] ?? null,
            'behance'   => $data['behance'] ?? null,
        ];

        unset(
            $data['instagram'],
            $data['facebook'],
            $data['linkedin'],
            $data['behance'],
        );

        return $data;
    }

    protected function afterCreate(): void
    {
        foreach ($this->socialLinks as $platform => $url) {
            if (empty($url)) {
                continue;
            }

            $this->record->socialLinks()->create([
                'platform' => $platform,
                'url'      => $url,
            ]);
        }
    }
}