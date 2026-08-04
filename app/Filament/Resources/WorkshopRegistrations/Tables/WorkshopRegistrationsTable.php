<?php

namespace App\Filament\Resources\WorkshopRegistrations\Tables;

use App\Enums\BookingStatus;
use App\Models\User;
use App\Services\Workshop\WorkshopRegistrationService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class WorkshopRegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),
                TextColumn::make('workshop.title')
                    ->Label('workshop')
                    ->searchable(),
                    TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(function ($state, $record) {

                        if ($record->trashed()) {
                            return 'Cancelled';
                        }

                        return ucfirst($state->value ?? $state);
                    })
                    ->color(function ($state, $record) {

                        if ($record->trashed()) {
                            return 'danger';
                        }

                        return match ($state) {
                            BookingStatus::CONFIRMED=> 'success',
                            BookingStatus::CANCELLED => 'danger',
                            default => 'gray',
                        };
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),

                SelectFilter::make('status')
                    ->label('Registration Status')
                    ->options([
                        BookingStatus::CONFIRMED->value => 'Confirmed',
                        BookingStatus::CANCELLED->value => 'Cancelled',
                    ]),

                SelectFilter::make('workshop_id')
                    ->label('Workshop')
                    ->relationship(
                        'Workshop',
                        'title'
                    )
                    ->searchable()
                    ->preload(),

                SelectFilter::make('user_id')
                    ->label('User')
                    ->relationship(
                        'user',
                        'first_name'
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn (User $record): string =>
                            "{$record->first_name} {$record->last_name}"
                    )
                    ->searchable(['first_name', 'last_name', 'email'])
                    ->preload(),

            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                Action::make('cancel')
                    ->label('Cancel Registration')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) =>
                        $record->status === BookingStatus::CONFIRMED
                    )
                    ->action(function ($record) {app(WorkshopRegistrationService::class)->cancelRegistration($record->id, $record->user_id);}),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
