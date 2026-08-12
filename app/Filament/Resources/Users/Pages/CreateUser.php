<?php

namespace App\Filament\Resources\Users\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
        $this->saveSocialLinks();
    
        $this->record->assignRole(RoleEnum::USER->value);
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