<?php

namespace App\Filament\Pages;

use App\Enums\RoleEnum;
use App\Filament\Widgets\WorkshopAttendanceByDayChart;
use App\Filament\Widgets\WorkshopOverviewStats;
use App\Filament\Widgets\UserWorkshopAttendanceBehaviorStats;
use App\Filament\Widgets\WorkshopAttendanceStats;
use App\Models\Workshop;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class WorkshopDashboard extends Page
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Workshop Dashboard';

    protected static ?string $title = 'Workshop Dashboard';

    protected string $view = 'filament.pages.workshop-dashboard';

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }

    public static function canAccess(): bool
    {
        return Auth::user()?->hasRole(RoleEnum::SUPER_ADMIN->value) ?? false;
    }

    public ?int $workshopId = null;

    public function mount(): void
    {
        $this->workshopId = Workshop::latest()
            ->value('id');
    }

    public function getWidgets(): array
    {
        return [
            WorkshopAttendanceStats::class,
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('workshopId')
                    ->label('Select Workshop')
                    ->options(
                        Workshop::query()
                            ->pluck('title', 'id')
                    )
                    ->searchable()
                    ->live(),
            ]);
    }

    public function getWidgetData(): array
    {
        return [
            'workshopId' => $this->workshopId,
        ];
    }

    public function updatedWorkshopId(): void
    {
        $this->dispatch(
            'workshopChanged',
            workshopId: $this->workshopId
        );
    }
}