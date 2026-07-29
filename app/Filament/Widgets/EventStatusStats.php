<?php

namespace App\Filament\Widgets;

use App\Enums\EventOccurrenceStatus;
use App\Models\EventOccurrence;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EventStatusStats extends StatsOverviewWidget
{
    protected function getHeading(): ?string
    {
        return 'Events Status';
    }
    protected function getStats(): array
    {
        return [

            Stat::make(
                'Upcoming Events',
                EventOccurrence::where(
                    'status',
                    EventOccurrenceStatus::UPCOMING->value
                )->count()
            )
            ->description('Not started yet')
            ->descriptionIcon('heroicon-m-clock')
            ->icon('heroicon-m-clock')
            ->color('warning'),


            Stat::make(
                'Active Events',
                EventOccurrence::where(
                    'status',
                    EventOccurrenceStatus::ACTIVE->value
                )->count()
            )
            ->description('Currently running')
            ->descriptionIcon('heroicon-m-play')
            ->icon('heroicon-m-play')
            ->color('success'),


            Stat::make(
                'Finished Events',
                EventOccurrence::where(
                    'status',
                    EventOccurrenceStatus::FINISHED->value
                )->count()
            )
            ->description('Completed')
            ->descriptionIcon('heroicon-m-check-circle')
            ->icon('heroicon-m-check-circle')
            ->color('gray'),

        ];
    }
}