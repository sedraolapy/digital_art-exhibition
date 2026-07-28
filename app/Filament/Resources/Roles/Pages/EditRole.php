<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Filament\Resources\Roles\RoleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        abort_if(
            $this->record->name === RoleEnum::SUPER_ADMIN->value,
            403
        );
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $rolePermissions = $this->record
            ->permissions
            ->pluck('name')
            ->toArray();

        $data['permissions'] = [];

        foreach (PermissionEnum::cases() as $permission) {

            if (in_array($permission->value, $rolePermissions)) {

                $data['permissions'][$permission->group()][] = $permission->value;

            }
        }

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $permissions = collect($data['permissions'] ?? [])
            ->flatten()
            ->filter()
            ->values()
            ->toArray();

        unset($data['permissions']);

        $record->update([
            'name' => $data['name'],
        ]);

        $record->syncPermissions($permissions);

        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(false),
        ];
    }
}