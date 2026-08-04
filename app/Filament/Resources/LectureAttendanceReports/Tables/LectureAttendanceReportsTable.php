<?php

namespace App\Filament\Resources\LectureAttendanceReports\Tables;

use App\Models\Lecture;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LectureAttendanceReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Lecture')
                    ->searchable(),

                TextColumn::make('day.day_number')
                    ->label('Day')
                    ->badge(),

                TextColumn::make('attendance_count')
                    ->label('Attendance')
                    ->counts('attendance')
                    ->badge()
                    ->sortable(),
            ])
            ->filters([

                SelectFilter::make('event_day_id')
                    ->label('Event Day')
                    ->relationship(
                        'day',
                        'day_number'
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn ($record) =>
                            "{$record->day_number} - {$record->occurrence->title}"
                    )
                    ->searchable()
                    ->preload(),

                SelectFilter::make('speaker_name')
                    ->label('Speaker')
                    ->options(
                        Lecture::query()
                            ->pluck('speaker_name', 'speaker_name')
                            ->unique()
                    )
                    ->searchable(),

                Filter::make('date')
                    ->form([
                        DatePicker::make('date')
                            ->label('Lecture Date'),
                    ])
                    ->query(function ($query, array $data) {

                        if (! filled($data['date'])) {
                            return;
                        }

                        $query->whereHas('day', function ($q) use ($data) {
                            $q->whereDate('date', $data['date']);
                        });
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
