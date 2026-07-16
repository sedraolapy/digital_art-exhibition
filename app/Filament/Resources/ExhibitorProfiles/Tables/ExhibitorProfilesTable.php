<?php

namespace App\Filament\Resources\ExhibitorProfiles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExhibitorProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('user.phone')
                    ->label('Phone')
                    ->searchable(),
                ImageColumn::make('image')
                    ->label('Exhibitor Image')
                    ->circular()
                    ->height(60)
                    ->width(60)
                    ->getStateUsing(fn ($record) =>
                        $record->getMedia('exhibitor_profile')
                            ->map(fn ($media) => $media->getUrl('webp'))
                        ),
                TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('experience_years')
                    ->numeric()
                    ->sortable(),
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
                ViewAction::make()->modal(),
                EditAction::make()->modal(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
