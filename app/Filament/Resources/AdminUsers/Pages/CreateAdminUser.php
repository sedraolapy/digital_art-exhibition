<?php

namespace App\Filament\Resources\AdminUsers\Pages;

use App\Filament\Resources\AdminUsers\AdminUserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAdminUser extends CreateRecord
{
    protected static string $resource = AdminUserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $role = $data['role'] ?? null;

        unset($data['role']);

        $this->role = $role;

        return $data;
    }


    protected function afterCreate(): void
    {
        if ($this->role) {
            $this->record->syncRoles($this->role);
        }
    }
}
