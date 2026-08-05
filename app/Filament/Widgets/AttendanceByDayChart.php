<?php

namespace App\Filament\Widgets;

use App\Enums\RoleEnum;
use App\Models\EventOccurrence;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class AttendanceByDayChart extends ChartWidget
{
    public ?int $eventOccurrenceId = null;

    public static function canView(): bool
    {
        return Auth::user()?->hasRole(RoleEnum::SUPER_ADMIN->value) ?? false;
    }


    protected ?string $heading = 'Attendance By Day';


    #[On('eventChanged')]
    public function updateEvent($eventOccurrenceId): void
    {
        $this->eventOccurrenceId = $eventOccurrenceId;
    }


    protected function getData(): array
    {
        if (! $this->eventOccurrenceId) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }


        $event = EventOccurrence::find($this->eventOccurrenceId);


        if (! $event) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }


        $days = $event->days()
            ->withCount('attendances')
            ->orderBy('day_number')
            ->get();


        return [

            'datasets' => [
                [
                    'label' => 'Visitors',
                    'data' => $days
                        ->pluck('attendances_count')
                        ->toArray(),
                ],
            ],


            'labels' => $days
                ->map(fn ($day) => "Day {$day->day_number}")
                ->toArray(),

        ];
    }


    protected function getType(): string
    {
        return 'bar';
    }
}