<?php

namespace App\Filament\Resources\Experiences\Tables;

use App\Enums\ExperienceStatus;
use App\Enums\RoleEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ExperiencesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date()
                    ->sortable()
                    ->placeholder('_'),
                TextColumn::make('status')
                    ->badge()
                    ->searchable()
                    ->color(fn ($state) => match ($state) {
                        ExperienceStatus::DRAFT => 'secondary',
                        ExperienceStatus::PUBLISHED => 'primary',
                        ExperienceStatus::ARCHIVED => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => ucfirst($state->value)),
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
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        ExperienceStatus::DRAFT->value => 'Draft',
                        ExperienceStatus::PUBLISHED->value => 'Published',
                        ExperienceStatus::ARCHIVED->value => 'Archived',
                    ]),

                Filter::make('date_range')
                    ->label('Date Range')
                    ->form([
                        DatePicker::make('start_date')
                            ->label('From'),

                        DatePicker::make('end_date')
                            ->label('To'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['start_date'],
                                fn ($query, $date) =>
                                    $query->whereDate('start_date', '>=', $date)
                            )
                            ->when(
                                $data['end_date'],
                                fn ($query, $date) =>
                                    $query->whereDate('end_date', '<=', $date)
                            );
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                Action::make('change_status')
                    ->label('Change Status')
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->form([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                ExperienceStatus::DRAFT->value => 'Draft',
                                ExperienceStatus::PUBLISHED->value => 'Published',
                                ExperienceStatus::ARCHIVED->value => 'Archived',
                            ])
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status' => $data['status'],
                        ]);
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn () => Auth::user()->hasRole(RoleEnum::SUPER_ADMIN->value)),
                ]),
            ]);
    }
}
