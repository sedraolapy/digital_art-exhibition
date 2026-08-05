<?php

namespace App\Filament\Widgets;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Models\EventAttendance;
use App\Models\EventOccurrence;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class UserAttendanceBehaviorStats extends StatsOverviewWidget
{
    public ?int $eventOccurrenceId = null;

    public static function canView(): bool
    {
        return Auth::user()?->hasRole(RoleEnum::SUPER_ADMIN->value) ?? false;
    }

    #[On('eventChanged')]
    public function updateEvent($eventOccurrenceId): void
    {
        $this->eventOccurrenceId = $eventOccurrenceId;
    }


    protected function getStats(): array
    {
        if (! $this->eventOccurrenceId) {
            return [];
        }


        $event = EventOccurrence::find($this->eventOccurrenceId);


        if (! $event) {
            return [];
        }


        $dayIds = $event->days()
            ->pluck('id');


        $totalDays = $dayIds->count();


        if ($totalDays === 0) {
            return [];
        }


        /*
         * Count attendance days for every user
         */
        $attendancePerUser = EventAttendance::whereIn(
            'event_day_id',
            $dayIds
        )
        ->selectRaw(
            'user_id, COUNT(DISTINCT event_day_id) as days'
        )
        ->groupBy('user_id')
        ->pluck('days');


        $totalUsers = User::count();


        $attendedUsers = $attendancePerUser->count();


        $neverAttended = $totalUsers - $attendedUsers;


        $oneDay = $attendancePerUser
            ->filter(fn ($days) => $days == 1)
            ->count();


        $multipleDays = $attendancePerUser
            ->filter(fn ($days) => $days > 1 && $days < $totalDays)
            ->count();


        $allDays = $attendancePerUser
            ->filter(fn ($days) => $days == $totalDays)
            ->count();


            $stats = [

                Stat::make(
                    'Never Attended',
                    number_format($neverAttended)
                )
                ->description('Registered users without check-in')
                ->icon('heroicon-o-user-minus')
                ->color('danger'),


                Stat::make(
                    'One Day Only',
                    number_format($oneDay)
                )
                ->description('Users attended one day')
                ->icon('heroicon-o-user')
                ->color('warning'),

            ];


            // Events with more than one day
            if ($totalDays > 1) {

                $stats[] = Stat::make(
                    'Multiple Days',
                    number_format($multipleDays)
                )
                ->description('Users attended multiple days')
                ->icon('heroicon-o-users')
                ->color('info');


                $stats[] = Stat::make(
                    'All Days',
                    number_format($allDays)
                )
                ->description("Attended all {$totalDays} days")
                ->icon('heroicon-o-star')
                ->color('success');

            }


            return $stats;
    }
}