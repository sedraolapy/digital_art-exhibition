<?php

namespace App\Filament\Widgets;

use App\Enums\RoleEnum;
use App\Models\Lecture;
use App\Models\EventOccurrence;
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


                $event = EventOccurrence::find(
                    $this->eventOccurrenceId
                );


                if (! $event) {
                    return Lecture::query()
                        ->whereRaw('1 = 0');
                }


                return Lecture::query()
                    ->whereIn(
                        'event_day_id',
                        $event->days()->pluck('id')
                    );
            })


            ->columns([


                Tables\Columns\TextColumn::make('title')
                    ->label('Lecture')
                    ->searchable(),


                Tables\Columns\TextColumn::make('speaker_name')
                    ->label('Speaker'),


                Tables\Columns\TextColumn::make('bookings_count')
                    ->label('Booked')
                    ->state(function (Lecture $record) {

                        return $record->bookings()->count();

                    })
                    ->badge()
                    ->color('info'),


                Tables\Columns\TextColumn::make('attendance_count')
                    ->label('Attended')
                    ->state(function (Lecture $record) {

                        return $record->attendance()->count();

                    })
                    ->badge()
                    ->color('success'),


                Tables\Columns\TextColumn::make('attendance_rate')
                    ->label('Attendance Rate')
                    ->state(function (Lecture $record) {

                        $booked = $record->bookings()->count();

                        $attended = $record->attendance()->count();


                        return $booked > 0
                            ? round(
                                ($attended / $booked) * 100,
                                1
                            ) . '%'
                            : '0%';

                    })
                    ->badge()
                    ->color('warning'),


            ])

            ->paginated(false);
    }
}
