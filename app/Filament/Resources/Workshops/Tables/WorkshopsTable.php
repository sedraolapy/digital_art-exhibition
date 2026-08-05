<?php

namespace App\Filament\Resources\Workshops\Tables;

use App\Enums\RoleEnum;
use App\Enums\WorkshopStatus;
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

class WorkshopsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('speaker_name')
                    ->searchable(),
                TextColumn::make('max_seats')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        WorkshopStatus::UPCOMING => 'warning',
                        WorkshopStatus::ACTIVE => 'success',
                        WorkshopStatus::FINISHED => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => $state->value)
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
                SelectFilter::make('status')
                    ->options([
                        WorkshopStatus::UPCOMING->value => 'upcoming',
                        WorkshopStatus::ACTIVE->value => 'active',
                        WorkshopStatus::FINISHED->value => 'finished',
                    ]),

                Filter::make('date')
                    ->form([
                        DatePicker::make('date'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['date'],
                                fn ($query, $date) => $query->whereDate('date', $date)
                            );
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('changeStatus')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->form([
                        Select::make('status')
                            ->options([
                                WorkshopStatus::UPCOMING->value => 'upcoming',
                                WorkshopStatus::ACTIVE->value => 'active',
                                WorkshopStatus::FINISHED->value => 'finished',
                            ])
                            ->required()
                            ->default(fn ($record) => $record->status->value),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status' => $data['status'],
                        ]);
                    })
                    ->successNotificationTitle('Workshop status updated successfully')
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn () => Auth::user()->hasRole(RoleEnum::SUPER_ADMIN->value)),
                ]),
            ]);
    }
}
