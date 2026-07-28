<?php

namespace App\Filament\Resources\ExhibitorProfiles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ExhibitorProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->badge(),
                TextColumn::make('experience_years')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('portfolio_url')
                    ->label('Portfolio')
                    ->url(fn ($state) => $state)
                    ->formatStateUsing(fn () => 'Visit Portfolio')
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->weight('medium')
                    ->icon('heroicon-o-link')
                    ->iconPosition('before'),
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
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('event_occurrences_id')
                    ->label('Event')
                    ->relationship('eventOccurrence', 'title')
                    ->searchable()
                    ->preload(),
                Filter::make('experience_years')
                    ->form([
                        TextInput::make('min')
                            ->numeric()
                            ->label('Min Years'),

                        TextInput::make('max')
                            ->numeric()
                            ->label('Max Years'),
                    ])
                    ->query(function ($query, array $data) {

                        return $query
                            ->when(
                                $data['min'],
                                fn ($query, $value) =>
                                    $query->where('experience_years', '>=', $value)
                            )
                            ->when(
                                $data['max'],
                                fn ($query, $value) =>
                                    $query->where('experience_years', '<=', $value)
                            );
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
