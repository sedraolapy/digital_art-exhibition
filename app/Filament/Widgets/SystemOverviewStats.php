<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Cycle;
use App\Models\EventOccurrence;
use App\Models\Lecture;
use App\Enums\RoleEnum;
use App\Models\ExhibitorProfile;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class SystemOverviewStats extends StatsOverviewWidget
{
    protected static bool $deferLoading = true;

    protected function getHeading(): ?string
    {
        return 'System Overview';
    }

    public static function canView(): bool
    {
        return Auth::user()?->hasRole(RoleEnum::SUPER_ADMIN->value) ?? false;
    }

    protected function getStats(): array
    {
        return [

            Stat::make(
                'Total Users',
                User::role(RoleEnum::USER->value)->count()
            )
            ->description('Registered users')
            ->descriptionIcon('heroicon-m-users')
            ->icon('heroicon-m-users')
            ->color('primary'),

            Stat::make(
                'Total Exhibitors',
                ExhibitorProfile::count()
            )
            ->description('All exhibitors')
            ->descriptionIcon('heroicon-m-building-storefront')
            ->icon('heroicon-m-building-storefront')
            ->color('danger'),


            Stat::make(
                'Total Cycles',
                Cycle::count()
            )
            ->description('Event cycles')
            ->descriptionIcon('heroicon-m-calendar')
            ->icon('heroicon-m-calendar')
            ->color('success'),


            Stat::make(
                'Total Events',
                EventOccurrence::count()
            )
            ->description('Event occurrences')
            ->descriptionIcon('heroicon-m-building-office')
            ->icon('heroicon-m-building-office')
            ->color('warning'),


        ];
    }
}
