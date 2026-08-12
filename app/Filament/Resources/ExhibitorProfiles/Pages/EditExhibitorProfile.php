<?php

namespace App\Filament\Resources\ExhibitorProfiles\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\ExhibitorProfiles\ExhibitorProfileResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditExhibitorProfile extends EditRecord
{
    protected static string $resource = ExhibitorProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                ->visible(fn () => Auth::user()->hasRole(RoleEnum::SUPER_ADMIN->value)),
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
