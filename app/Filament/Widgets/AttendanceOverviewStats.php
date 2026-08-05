<?php

namespace App\Filament\Widgets;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Models\EventAttendance;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class AttendanceOverviewStats extends StatsOverviewWidget
{

    protected function getHeading(): ?string
    {
        return 'Attendance Overview';
    }

    public static function canView(): bool
    {
        return Auth::user()?->hasRole(RoleEnum::SUPER_ADMIN->value) ?? false;
    }

    protected function getStats(): array
    {
        $totalUsers = User::role(RoleEnum::USER->value)
            ->count();


        $attendees = EventAttendance::query()
            ->distinct('user_id')
            ->count('user_id');


        $notAttended = max(
            $totalUsers - $attendees,
            0
        );


        $attendanceRate = $totalUsers > 0
            ? round(($attendees / $totalUsers) * 100, 1)
            : 0;


        return [

            Stat::make(
                'Total Registered Users',
                $totalUsers
            )
            ->description('Users registered')
            ->icon('heroicon-m-users')
            ->color('primary'),


            Stat::make(
                'Total Attendees',
                $attendees
            )
            ->description('Checked-in users')
            ->icon('heroicon-m-check-circle')
            ->color('success'),


            Stat::make(
                'Not Attended',
                $notAttended
            )
            ->description('Registered but no check-in')
            ->icon('heroicon-m-x-circle')
            ->color('danger'),


            Stat::make(
                'Attendance Rate',
                $attendanceRate . '%'
            )
            ->description('Overall attendance')
            ->icon('heroicon-m-chart-bar')
            ->color(
                $attendanceRate >= 70
                    ? 'success'
                    : 'warning'
            ),

        ];
    }
}