<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\EventOccurrence;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Livewire\Attributes\On;

class EventOverviewStats extends StatsOverviewWidget
{
    public ?int $eventOccurrenceId = null;


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


        $totalUsers = User::count();


        $eventVisitors = $event->days()
            ->withCount('attendances')
            ->get()
            ->pluck('attendances_count')
            ->sum();


        return [

            Stat::make(
                'Total Users',
                number_format($totalUsers)
            )
            ->description('All registered accounts')
            ->icon('heroicon-o-users')
            ->color('primary'),


            Stat::make(
                'Event Visitors',
                number_format($eventVisitors)
            )
            ->description('Users checked in')
            ->icon('heroicon-o-user-group')
            ->color('success'),


            Stat::make(
                'Event Days',
                $event->days()->count()
            )
            ->description('Days of event')
            ->icon('heroicon-o-calendar-days')
            ->color('info'),

        ];
    }
}