<?php

namespace App\Filament\Widgets;

use App\Enums\BookingStatus;
use App\Enums\RoleEnum;
use App\Models\Workshop;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class WorkshopAttendanceStats extends StatsOverviewWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static bool $deferLoading = true;

    public ?int $workshopId = null;

    public static function canView(): bool
    {
        return Auth::user()?->hasRole(RoleEnum::SUPER_ADMIN->value) ?? false;
    }
    
    #[On('workshopChanged')]
    public function updateWorkshop(int $workshopId): void
    {
        $this->workshopId = $workshopId;

        $this->dispatch('$refresh');
    }

    protected function getStats(): array
    {
        $workshop = Workshop::query()
            ->withCount([
                'registrations' => fn ($query) =>
                    $query->where(
                        'status',
                        BookingStatus::CONFIRMED->value
                    ),

                'attendance',
            ])
            ->find($this->workshopId);

        if (! $workshop) {
            return [];
        }

        return [
            Stat::make(
                'Registered',
                $workshop->registrations_count
            )
                ->description('Confirmed registrations')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('primary'),

            Stat::make(
                'Attended',
                $workshop->attendance_count
            )
                ->description('People who attended')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make(
                'Attendance Rate',
                $workshop->registrations_count > 0
                    ? round(
                        ($workshop->attendance_count / $workshop->registrations_count) * 100,
                        1
                    ) . '%'
                    : '0%'
            )
                ->description('Attendance percentage')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('info'),
        ];
    }
}