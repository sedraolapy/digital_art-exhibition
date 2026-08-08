<?php

namespace App\Filament\Resources\Cycles\Tables;

use App\Enums\CycleStatus;
use App\Enums\EventOccurrenceStatus;
use App\Models\Cycle;
use App\Models\EventOccurrence;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get as UtilitiesGet;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;


class CyclesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        CycleStatus::UPCOMING => 'warning',
                        CycleStatus::ACTIVE => 'success',
                        CycleStatus::FINISHED => 'danger',
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
                    ->label('Status')
                    ->options([
                        CycleStatus::UPCOMING->value => 'Upcoming',
                        CycleStatus::ACTIVE->value => 'Active',
                        CycleStatus::FINISHED->value => 'Finished',
                    ]),
                Filter::make('date_range')
                    ->label('Cycle Date Range')
                    ->form([
                        DatePicker::make('from')
                            ->label('From date'),

                        DatePicker::make('until')
                            ->label('Until date'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['from'] ?? null,
                                fn ($query, $date) =>
                                    $query->whereDate('start_date', '>=', $date)
                            )
                            ->when(
                                $data['until'] ?? null,
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
                ->icon('heroicon-o-arrow-path')
                ->disabled(
                    fn (Cycle $record) =>
                        $record->status === CycleStatus::FINISHED
                )

                ->form([
                    Select::make('status')
                        ->label('Status')
                        ->options([
                            CycleStatus::UPCOMING->value => 'Upcoming',
                            CycleStatus::ACTIVE->value => 'Active',
                            CycleStatus::FINISHED->value => 'Finished',
                        ])
                        ->required()
                        ->live(),

                    Placeholder::make('warning')
                        ->hidden(
                            fn (UtilitiesGet $get) =>
                                $get('status') !== CycleStatus::FINISHED->value
                        )
                        ->content(
                            '⚠️ Warning: Once the cycle is marked as FINISHED, its status cannot be changed again.'
                        ),
                ])

                ->action(function (Cycle $record, array $data) {

                    if ($record->status === CycleStatus::FINISHED) {

                        Notification::make()
                            ->title('Cannot change status')
                            ->body(
                                'This cycle is already finished and its status cannot be changed.'
                            )
                            ->danger()
                            ->send();

                        return;
                    }

                    if ($data['status'] === CycleStatus::ACTIVE->value) {

                        $alreadyActive = Cycle::query()
                            ->where(
                                'status',
                                CycleStatus::ACTIVE->value
                            )
                            ->where('id', '!=', $record->id)
                            ->exists();

                        if ($alreadyActive) {

                            Notification::make()
                                ->title('Cannot activate cycle')
                                ->body(
                                    'There is already another active cycle. You must change its status before activating this cycle.'
                                )
                                ->danger()
                                ->persistent()
                                ->send();

                            return;
                        }
                    }

                    if ($data['status'] === CycleStatus::FINISHED->value) {

                        $hasActiveOccurrence = $record->occurrences()
                            ->where(
                                'status',
                                EventOccurrenceStatus::ACTIVE->value
                            )
                            ->exists();

                        if ($hasActiveOccurrence) {

                            Notification::make()
                                ->title('Cannot finish cycle')
                                ->body(
                                    'This cycle cannot be marked as finished because it still has an active event.'
                                )
                                ->danger()
                                ->persistent()
                                ->send();

                            return;
                        }

                        $record->update([
                            'status' => CycleStatus::FINISHED,
                        ]);

                        Notification::make()
                            ->title('Cycle Finished')
                            ->body(
                                'The cycle has been finished successfully.'
                            )
                            ->success()
                            ->send();

                        return;
                    }

                    $record->update([
                        'status' => $data['status'],
                    ]);

                    Notification::make()
                        ->title('Status Updated')
                        ->body(
                            'Cycle status has been updated successfully.'
                        )
                        ->success()
                        ->send();
                }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
