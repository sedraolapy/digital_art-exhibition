<?php

namespace App\Filament\Resources\EventOccurrences\Tables;

use App\Enums\EventOccurrenceStatus;
use App\Models\EventOccurrence;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class EventOccurrencesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('location.name')
                    ->searchable(),

                IconColumn::make('is_voting_enabled')
                    ->boolean(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        EventOccurrenceStatus::UPCOMING => 'warning',
                        EventOccurrenceStatus::ACTIVE => 'success',
                        EventOccurrenceStatus::FINISHED => 'danger',
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
                        EventOccurrenceStatus::UPCOMING->value => 'Upcoming',
                        EventOccurrenceStatus::ACTIVE->value => 'Active',
                        EventOccurrenceStatus::FINISHED->value => 'Finished',
                    ]),

                TernaryFilter::make('is_voting_enabled')
                    ->label('Voting Enabled')
                    ->placeholder('All events')
                    ->trueLabel('Voting enabled')
                    ->falseLabel('Voting disabled'),

                    SelectFilter::make('cycle_id')
                    ->label('Cycle')
                    ->relationship('cycle', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('location_id')
                    ->label('Location')
                    ->relationship('location', 'name')
                    ->searchable()
                    ->preload(),

                    Filter::make('date_range')
                    ->label('Event Date Range')
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
                    ->disabled(
                        fn (EventOccurrence $record) =>
                        $record->status === EventOccurrenceStatus::FINISHED
                    )
                    ->form([

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                EventOccurrenceStatus::UPCOMING->value => 'Upcoming',
                                EventOccurrenceStatus::ACTIVE->value => 'Active',
                                EventOccurrenceStatus::FINISHED->value => 'Finished',
                            ])
                            ->required()
                            ->live(),


                        Placeholder::make('warning')
                            ->hidden(
                                fn (Get $get) =>
                                $get('status') !== EventOccurrenceStatus::FINISHED->value
                            )
                            ->content(
                                '⚠️ Warning: If you change the event status to FINISHED, voting will be disabled and the status cannot be changed again.'
                            ),
                    ])

                    ->action(function (EventOccurrence $record, array $data) {

                        /**
                         * Prevent multiple active events
                         */
                        if ($data['status'] === EventOccurrenceStatus::ACTIVE->value) {

                            $alreadyActive = EventOccurrence::query()
                                ->where(
                                    'status',
                                    EventOccurrenceStatus::ACTIVE->value
                                )
                                ->where('id', '!=', $record->id)
                                ->exists();


                            if ($alreadyActive) {

                                Notification::make()
                                    ->title('Error')
                                    ->body(
                                        'There is already another ACTIVE event. Change its status first.'
                                    )
                                    ->danger()
                                    ->persistent()
                                    ->send();

                                return;
                            }
                        }


                        /**
                         * If event becomes finished
                         */
                        if ($data['status'] === EventOccurrenceStatus::FINISHED->value) {

                            $record->update([
                                'status' => EventOccurrenceStatus::FINISHED,
                                'is_voting_enabled' => false,
                            ]);


                            Notification::make()
                                ->title('Event Finished')
                                ->body(
                                    'The event is finished and voting has been disabled.'
                                )
                                ->success()
                                ->send();

                            return;
                        }


                        /**
                         * Normal status update
                         */
                        $record->update([
                            'status' => $data['status'],
                        ]);


                        Notification::make()
                            ->title('Status Updated')
                            ->body(
                                'Event status has been updated successfully.'
                            )
                            ->success()
                            ->send();
                    }),



                Action::make('toggle_voting')
                    ->label(
                        fn (EventOccurrence $record) =>
                        $record->is_voting_enabled
                            ? 'Disable Voting'
                            : 'Enable Voting'
                    )
                    ->icon(
                        fn (EventOccurrence $record) =>
                        $record->is_voting_enabled
                            ? 'heroicon-o-x-circle'
                            : 'heroicon-o-check-circle'
                    )
                    ->color(
                        fn (EventOccurrence $record) =>
                        $record->is_voting_enabled
                            ? 'danger'
                            : 'success'
                    )
                    ->requiresConfirmation()

                    ->disabled(
                        fn (EventOccurrence $record) =>
                        $record->status !== EventOccurrenceStatus::ACTIVE
                    )

                    ->action(function (EventOccurrence $record) {

                        if ($record->is_voting_enabled) {

                            $record->update([
                                'is_voting_enabled' => false,
                            ]);

                            Notification::make()
                                ->title('Voting Disabled')
                                ->success()
                                ->send();

                        } else {

                            EventOccurrence::query()
                                ->update([
                                    'is_voting_enabled' => false,
                                ]);

                            $record->update([
                                'is_voting_enabled' => true,
                            ]);


                            Notification::make()
                                ->title('Voting Enabled')
                                ->success()
                                ->send();
                        }
                    }),

            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}