<?php

namespace App\Filament\Resources\Lectures\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LecturesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                ImageColumn::make('image')
                    ->label('Lecture Image')
                    ->circular()
                    ->height(60)
                    ->width(60)
                    ->getStateUsing(fn ($record) =>
                        $record->getMedia('lectures')
                            ->map(fn ($media) => $media->getUrl('webp'))
                        ),
                TextColumn::make('speaker_name')
                    ->searchable(),
                TextColumn::make('max_seats')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('day.day_number')
                    ->label('Event day')
                    ->sortable(),
                TextColumn::make('start_time')
                    ->time()
                    ->sortable(),
                TextColumn::make('end_time')
                    ->time()
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
