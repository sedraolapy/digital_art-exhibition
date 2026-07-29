<?php

namespace App\Filament\Resources\EventAttendanceReports\Tables;

use App\Models\EventDay;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EventAttendanceReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('day_number')
                    ->label('Day')
                    ->badge(),

                TextColumn::make('occurrence.title')
                    ->label('Event')
                    ->searchable(),

                TextColumn::make('date')
                    ->label('Date')
                    ->date(),

                TextColumn::make('attendances_count')
                    ->label('Total Attendance')
                    ->counts('attendances')
                    ->badge()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('id')
                    ->label('Event Day')
                    ->options(
                        EventDay::with('occurrence')
                            ->get()
                            ->mapWithKeys(fn ($day) => [
                                $day->id => "{$day->day_number} - {$day->occurrence->title}",
                            ])
                    )
                    ->searchable()
                    ->preload(),
                Filter::make('date')
                    ->form([
                        DatePicker::make('date')
                            ->label('Event Date'),
                    ])
                    ->query(function ($query, array $data) {

                        if (! filled($data['date'])) {
                            return;
                        }

                        $query->whereDate('date', $data['date']);
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
