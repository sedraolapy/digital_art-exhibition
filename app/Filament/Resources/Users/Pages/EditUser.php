<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $this->saveSocialLinks();
    }

    protected function saveSocialLinks(): void
    {
        $profile = $this->record->userProfile()->firstOrCreate([]);

        foreach (['instagram', 'facebook'] as $platform) {

            $url = $this->data[$platform] ?? null;

            if (filled($url)) {

                $profile->socialLinks()->updateOrCreate(
                    ['platform' => $platform],
                    ['url' => $url]
                );

            } else {

                $profile->socialLinks()
                    ->where('platform', $platform)
                    ->delete();
            }
        }
    }
}
