<?php

namespace App\Filament\Resources\EventOccurrences\Tables;

use App\Enums\EventOccurrenceStatus;
use App\Models\EventOccurrence;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class EventOccurrencesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('cycle.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('location.name')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_voting_enabled')
                    ->boolean(),
                TextColumn::make('status')
                    ->badge()
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
                ViewAction::make()->modal(),
                EditAction::make()->modal(),

                Action::make('change_status')
                    ->label('Change Status')
                    ->form([
                        Select::make('status')
                            ->label('Status')
                            ->options(EventOccurrenceStatus::class)
                            ->required(),
                    ])
                    ->action(function ($record, array $data) {
                        if ($data['status'] === EventOccurrenceStatus::ACTIVE) {
                            $alreadyActive = EventOccurrence::query()
                                ->where('status', EventOccurrenceStatus::ACTIVE)
                                ->where('id', '!=', $record->id)
                                ->exists();

                            if ($alreadyActive) {
                                Notification::make()
                                    ->title('Error')
                                    ->body('There is already another ACTIVE event. You must change its status before activating this one.')
                                    ->danger()
                                    ->persistent() 
                                    ->send();

                                return;
                            }
                        } else {
                            if ($record->status === EventOccurrenceStatus::ACTIVE) {
                                $record->update(['is_voting_enabled' => false]);
                            }
                        }
                        $record->update(['status' => $data['status']]);
                    }),

                    Action::make('toggle_voting')
                    ->label(fn ($record) => $record->is_voting_enabled ? 'Disable Voting' : 'Enable Voting')
                    ->icon(fn ($record) => $record->is_voting_enabled ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn ($record) => $record->is_voting_enabled ? 'danger' : 'success')
                    ->requiresConfirmation()
                    ->disabled(fn ($record) => $record->status !== EventOccurrenceStatus::ACTIVE)
                    ->action(function ($record) {
                        if ($record->is_voting_enabled) {
                            $record->update(['is_voting_enabled' => false]);
                        } else {
                            EventOccurrence::query()->update(['is_voting_enabled' => false]);
                            $record->update(['is_voting_enabled' => true]);
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
