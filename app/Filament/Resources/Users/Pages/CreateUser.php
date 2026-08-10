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
        $data = $this->data;
        $user = $this->record;

        $user->assignRole(RoleEnum::USER->value);

        if (! empty($data['instagram'])) {
            $user->socialLinks()->create([
                'platform' => 'instagram',
                'url' => $data['instagram'],
            ]);
        }

        if (! empty($data['facebook'])) {
            $user->socialLinks()->create([
                'platform' => 'facebook',
                'url' => $data['facebook'],
            ]);
        }

    }
}