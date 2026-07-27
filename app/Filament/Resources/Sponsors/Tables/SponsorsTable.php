<?php

namespace App\Filament\Resources\Sponsors\Tables;

use App\Enums\SponsorType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SponsorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->getStateUsing(fn ($record) => $record->getFirstMediaUrl('sponsors'))
                    ->height(50),
                TextColumn::make('type')
                    ->badge()
                    ->searchable()
                    ->color(fn ($state) => match ($state) {
                        SponsorType::DIAMOND => 'info',
                        SponsorType::GOLD => 'warning',
                        SponsorType::SILVER => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst($state->value)),
                TextColumn::make('cycles_count')
                    ->counts('cycles')
                    ->label('Cycles'),
                TextColumn::make('occurrences_count')
                    ->counts('occurrences')
                    ->label('Events'),
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
                SelectFilter::make('type')
                    ->options([
                        'diamond'=>'Diamond',
                        'gold'=>'Gold',
                        'silver'=>'Silver',
                    ])
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
