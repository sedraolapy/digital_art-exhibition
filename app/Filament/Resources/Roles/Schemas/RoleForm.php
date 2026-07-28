<?php

namespace App\Filament\Resources\Roles\Schemas;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        $components = [
            TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->disabled(fn ($record) => $record?->name === RoleEnum::SUPER_ADMIN->value),
        ];

        foreach (collect(PermissionEnum::cases())->groupBy(fn ($permission) => $permission->group()) as $group => $permissions) {

            $components[] = Group::make([
                CheckboxList::make("permissions.$group")
                    ->label($group)
                    ->options(
                        $permissions
                            ->mapWithKeys(fn ($permission) => [
                                $permission->value => $permission->label(),
                            ])
                            ->toArray()
                    )
                    ->columns(2),
            ])->columnSpanFull();
        }

        return $schema->components($components);
    }
}