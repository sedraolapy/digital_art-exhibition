<?php

namespace App\Filament\Widgets;

use App\Enums\RoleEnum;
use App\Models\EventOccurrence;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class EventAttendanceRanking extends BaseWidget
{
    protected static ?string $heading = 'Top Events by Attendance';

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return Auth::user()?->hasRole(RoleEnum::SUPER_ADMIN->value) ?? false;
    }

    protected function getTableQuery(): Builder
    {
        return EventOccurrence::query()
            ->withCount('attendances')
            ->orderByDesc('attendances_count')
            ->limit(5);
    }


    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('title')
                ->label('Event'),

            Tables\Columns\TextColumn::make('attendances_count')
                ->label('Attendance')
                ->badge()
                ->color('success'),
        ];
    }
}