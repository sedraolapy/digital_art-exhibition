<?php

namespace App\Filament\Resources\ExhibitorApplications\Tables;

use App\Enums\ExhibitorStatus;
use App\Enums\RoleEnum;
use App\Models\ExhibitorApplication;
use App\Services\Exhibitor\ExhibitorApplicationService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ExhibitorApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),

                ImageColumn::make('image')
                    ->label('Exhibitor Image')
                    ->circular()
                    ->height(60)
                    ->width(60)
                    ->getStateUsing(
                        fn ($record) => $record
                            ->getMedia('application_image')
                            ->map(
                                fn ($media) => $media->getUrl('webp')
                            )
                    ),

                TextColumn::make('category.name')
                    ->badge()
                    ->searchable(),

                TextColumn::make('portfolio_url')
                    ->label('Portfolio')
                    ->url(fn ($state) => $state)
                    ->formatStateUsing(fn () => 'Visit Portfolio')
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->weight('medium')
                    ->icon('heroicon-o-link')
                    ->iconPosition('before'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->searchable()
                    ->formatStateUsing(
                        fn (ExhibitorStatus $state) => match ($state) {
                            ExhibitorStatus::PENDING =>
                                'Pending',

                            ExhibitorStatus::REJECTED =>
                                'Rejected',

                            ExhibitorStatus::APPROVED_INITIAL =>
                                'Approved (Initial)',

                            ExhibitorStatus::APPROVED_FINAL =>
                                'Approved (Final)',
                        }
                    )
                    ->color(
                        fn (ExhibitorStatus $state) => match ($state) {
                            ExhibitorStatus::PENDING =>
                                'warning',

                            ExhibitorStatus::REJECTED =>
                                'danger',

                            ExhibitorStatus::APPROVED_INITIAL =>
                                'info',

                            ExhibitorStatus::APPROVED_FINAL =>
                                'success',
                        }
                    ),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(
                        isToggledHiddenByDefault: true
                    ),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(
                        isToggledHiddenByDefault: true
                    ),
            ])

            ->filters([

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        ExhibitorStatus::PENDING->value =>
                            'Pending',

                        ExhibitorStatus::APPROVED_INITIAL->value =>
                            'Approved (Initial)',

                        ExhibitorStatus::APPROVED_FINAL->value =>
                            'Approved (Final)',

                        ExhibitorStatus::REJECTED->value =>
                            'Rejected',
                    ]),

                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('event_occurrence_id')
                    ->relationship('eventOccurrence', 'title')
                    ->label('Event')
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
                                filled($data['min']),
                                fn ($q) => $q->where(
                                    'experience_years',
                                    '>=',
                                    $data['min']
                                )
                            )
                            ->when(
                                filled($data['max']),
                                fn ($q) => $q->where(
                                    'experience_years',
                                    '<=',
                                    $data['max']
                                )
                            );
                    }),

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from'),

                        DatePicker::make('until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['from'] ?? null,
                                fn ($q) => $q->whereDate(
                                    'created_at',
                                    '>=',
                                    $data['from']
                                )
                            )
                            ->when(
                                $data['until'] ?? null,
                                fn ($q) => $q->whereDate(
                                    'created_at',
                                    '<=',
                                    $data['until']
                                )
                            );
                    }),
            ])

            ->recordActions([

                ViewAction::make(),

                EditAction::make()
                    ->visible(
                        fn () => Auth::user()
                            ->hasRole(
                                RoleEnum::SUPER_ADMIN->value
                            )
                    ),

                Action::make('approveInitial')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(
                        fn (ExhibitorApplication $record) =>$record->status ===ExhibitorStatus::PENDING
                    )
                    ->action(
                        function (ExhibitorApplication $record) {
                            app(ExhibitorApplicationService::class)->approveInitial($record);
                        }
                    ),

    
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(
                        fn (ExhibitorApplication $record) =>
                            in_array($record->status,
                                [
                                    ExhibitorStatus::PENDING,
                                    ExhibitorStatus::APPROVED_INITIAL,
                                ],true
                            )
                    )
                    ->action(
                        function (ExhibitorApplication $record) {
                            app(ExhibitorApplicationService::class)->reject($record);
                        }
                    ),

    
                Action::make('approveFinal')
                    ->label('Final Approval')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(
                        fn (ExhibitorApplication $record) =>$record->status ===ExhibitorStatus::APPROVED_INITIAL
                    )
                    ->action(
                        function (ExhibitorApplication $record) {
                            app(ExhibitorApplicationService::class)->approveFinal($record);
                        }
                    ),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}