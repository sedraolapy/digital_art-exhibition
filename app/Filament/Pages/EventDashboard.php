<?php

namespace App\Filament\Pages;

use App\Enums\RoleEnum;
use App\Filament\Widgets\AttendanceByDayChart;
use App\Filament\Widgets\UserAttendanceBehaviorStats;
use App\Models\EventOccurrence;
use Filament\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Auth;

class EventDashboard extends Page
{
    use InteractsWithForms;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Event Dashboard';

    protected static ?string $title = 'Event Dashboard';

    protected string $view = 'filament.pages.event-dashboard';

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }

    public static function canAccess(): bool
    {
        return Auth::user()?->hasRole(RoleEnum::SUPER_ADMIN->value) ?? false;
    }


    public ?int $eventOccurrenceId = null;


    public function mount(): void
    {
        $this->eventOccurrenceId = EventOccurrence::latest()
            ->value('id');
    }

    public function getWidgets(): array
    {
        return [
            AttendanceByDayChart::class,
            UserAttendanceBehaviorStats::class,
        ];
    }


    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('eventOccurrenceId')
                    ->label('Select Event')
                    ->options(
                        EventOccurrence::query()
                            ->pluck('title', 'id')
                    )
                    ->searchable()
                    ->live(),
            ]);
    }


    public function getWidgetData(): array
    {
        return [
            'eventOccurrenceId' => $this->eventOccurrenceId,
        ];
    }

    public function updatedEventOccurrenceId()
    {
        $this->dispatch('eventChanged', eventOccurrenceId: $this->eventOccurrenceId);
    }
}