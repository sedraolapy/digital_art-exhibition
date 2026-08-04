<?php

namespace App\Filament\Resources\WorkshopAttendanceReports\Tables;

use App\Enums\WorkshopStatus;
use App\Models\Workshop;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WorkshopAttendanceReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                ->label('Workshop')
                ->searchable(),

                TextColumn::make('attendance_count')
                    ->label('Attendance')
                    ->counts('attendance')
                    ->badge()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        WorkshopStatus::UPCOMING->value => 'Upcoming',
                        WorkshopStatus::ACTIVE->value => 'Active',
                        WorkshopStatus::FINISHED->value => 'Finished',
                    ]),

                SelectFilter::make('speaker_name')
                    ->label('Speaker')
                    ->options(fn () => Workshop::query()
                        ->orderBy('speaker_name')
                        ->pluck('speaker_name', 'speaker_name')
                        ->toArray())
                    ->searchable(),

                Filter::make('date')
                    ->label('Workshop Date')
                    ->form([
                        DatePicker::make('date'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when(
                            $data['date'] ?? null,
                            fn ($query, $date) => $query->whereDate('date', $date)
                        );
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                ]),
            ]);
    }
}
