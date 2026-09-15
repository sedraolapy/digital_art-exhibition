<?php

namespace App\Filament\Resources\Users\Tables;

use App\Enums\RoleEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                ImageColumn::make('image')
                    ->label('Image')
                    ->circular()
                    ->size(70)
                    ->getStateUsing(function ($record) {
                        return $record->userProfile?->getFirstMediaUrl('user_image')
                            ?: null;
                    }),
                TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        return ucwords(str_replace('_', ' ', $state));
                    }),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
