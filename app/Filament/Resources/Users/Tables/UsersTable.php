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
                    ->searchable()
                    ->url(fn ($record) => $record->hasRole(RoleEnum::EXHIBITOR->value)
                        ? route('filament.admin.resources.exhibitor-profiles.view', $record->exhibitorProfile)
                        : null
                    )
                    ->color(fn ($record) => $record->hasRole(RoleEnum::EXHIBITOR->value)
                        ? 'primary'
                        : null
                    )
                    ->weight(fn ($record) => $record->hasRole(RoleEnum::EXHIBITOR->value)
                        ? 'medium'
                        : null
                    )
                    ->icon(fn ($record) => $record->hasRole(RoleEnum::EXHIBITOR->value)
                        ? 'heroicon-o-link'
                        : null
                    )
                    ->iconPosition('before'),
                ImageColumn::make('image')
                    ->label('Image')
                    ->circular()
                    ->size(70)
                    ->getStateUsing(function ($record) {
                        return $record->userProfile?->getFirstMediaUrl('user_image', 'webp')
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
                SelectFilter::make('role')
                    ->label('Role')
                    ->options([
                        RoleEnum::USER->value => 'User',
                        RoleEnum::EXHIBITOR->value => 'Exhibitor',
                    ])
                    ->query(function ($query, array $data) {

                        if (! filled($data['value'])) {
                            return $query;
                        }

                        return $query->whereHas('roles', function ($query) use ($data) {
                            $query->where('name', $data['value']);
                        });
                    }),
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
