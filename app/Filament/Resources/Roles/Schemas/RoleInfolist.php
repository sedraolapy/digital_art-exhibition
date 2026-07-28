<?php

namespace App\Filament\Resources\Roles\Schemas;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RoleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Role')
                    ->badge(),

                TextEntry::make('users_count')
                    ->label('Users')
                    ->state(fn ($record) => $record->users()->count())
                    ->badge(),

                TextEntry::make('permissions_count')
                    ->label('Permissions')
                    ->state(function ($record) {
                        return $record->name === RoleEnum::SUPER_ADMIN->value
                            ? 'Full Access'
                            : $record->permissions()->count();
                    })
                    ->badge(),

                TextEntry::make('super_admin_access')
                    ->label('Permissions')
                    ->state(function ($record) {
                        return $record->name === RoleEnum::SUPER_ADMIN->value
                            ? 'All permissions'
                            : null;
                    })
                    ->badge()
                    ->visible(fn ($record) =>
                        $record->name === RoleEnum::SUPER_ADMIN->value
                    ),

                RepeatableEntry::make('permissions')
                    ->label('Permissions')
                    ->visible(fn ($record) =>
                        $record->name !== RoleEnum::SUPER_ADMIN->value
                    )
                    ->schema([
                        TextEntry::make('name')
                            ->label('Permission')
                            ->formatStateUsing(function (string $state) {
                                $permission = PermissionEnum::tryFrom($state);

                                return $permission?->label() ?? $state;
                            })
                            ->badge(),

                        TextEntry::make('name')
                            ->label('Group')
                            ->formatStateUsing(function (string $state) {
                                $permission = PermissionEnum::tryFrom($state);

                                return $permission?->group() ?? '-';
                            })
                            ->badge()
                            ->color('gray'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}