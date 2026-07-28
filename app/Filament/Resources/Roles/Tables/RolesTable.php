<?php

namespace App\Filament\Resources\Roles\Tables;

use App\Enums\RoleEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RolesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Role')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('users_count')
                    ->label('Users')
                    ->counts('users')
                    ->badge()
                    ->sortable(),

                TextColumn::make('permissions_count')
                    ->label('Permissions')
                    ->state(function ($record) {
                        return $record->name === RoleEnum::SUPER_ADMIN->value
                            ? 'All'
                            : $record->permissions()->count();
                    })
                    ->badge(),
                    
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                SelectFilter::make('name')
                    ->label('Role')
                    ->options(
                        collect(RoleEnum::cases())
                            ->mapWithKeys(fn ($role) => [
                                $role->value => ucwords(str_replace('_', ' ', $role->value)),
                            ])
                            ->toArray()
                    ),
            ])

            ->recordActions([
                ViewAction::make(),

                EditAction::make()
                    ->visible(fn ($record) => $record->name !== RoleEnum::SUPER_ADMIN->value),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(false),
                ]),
            ])

            ->defaultSort('name');
    }


}
