<?php

namespace App\Filament\Resources\AdminUsers\Pages;

use App\Filament\Resources\AdminUsers\AdminUserResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAdminUser extends EditRecord
{
    protected static string $resource = AdminUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];


    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $role = $data['role'] ?? null;

        unset($data['role']);

        $this->role = $role;

        return $data;
    }


    protected function afterSave(): void
    {
        if ($this->role) {
            $this->record->syncRoles($this->role);
        }
    }
}
