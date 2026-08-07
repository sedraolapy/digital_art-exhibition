<?php

namespace App\Filament\Widgets;

use App\Enums\RoleEnum;
use App\Models\Lecture;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class LecturePerformanceTable extends TableWidget
{
    public ?int $eventOccurrenceId = null;


    #[On('eventChanged')]
    public function updateEvent($eventOccurrenceId): void
    {
        $this->eventOccurrenceId = $eventOccurrenceId;
    }


    public static function canView(): bool
    {
        return Auth::user()?->hasRole(RoleEnum::SUPER_ADMIN->value) ?? false;
    }


    public function table(Table $table): Table
    {
        return $table
            ->query(function () {

                if (! $this->eventOccurrenceId) {
                    return Lecture::query()
                        ->whereRaw('1 = 0');
                }


                return Lecture::query()
                    ->whereHas('day', function ($query) {
                        $query->where(
                            'event_occurrence_id',
                            $this->eventOccurrenceId
                        );
                    })
                    ->withCount([
                        'bookings',
                        'attendance',
                    ]);
            })

            ->columns([

                Tables\Columns\TextColumn::make('title')
                    ->label('Lecture')
                    ->searchable(),


                Tables\Columns\TextColumn::make('speaker_name')
                    ->label('Speaker'),


                Tables\Columns\TextColumn::make('bookings_count')
                    ->label('Booked')
                    ->badge()
                    ->color('info'),


                Tables\Columns\TextColumn::make('attendance_count')
                    ->label('Attended')
                    ->badge()
                    ->color('success'),


                Tables\Columns\TextColumn::make('attendance_rate')
                    ->label('Attendance Rate')
                    ->state(function (Lecture $record) {

                        if ($record->bookings_count == 0) {
                            return '0%';
                        }

                        return round(
                            ($record->attendance_count / $record->bookings_count) * 100,
                            1
                        ) . '%';
                    })
                    ->badge()
                    ->color('warning'),

            ])

            ->paginated(false);
    }
}