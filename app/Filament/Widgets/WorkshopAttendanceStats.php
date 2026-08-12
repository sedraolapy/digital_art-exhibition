<?php

namespace App\Filament\Widgets;

use App\Enums\RoleEnum;
use App\Models\Workshop as ModelsWorkshop;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Tables;
use App\Enums\BookingStatus;

class WorkshopAttendanceStats extends TableWidget
{
    public ?int $workshopId = null;

    public static function canView(): bool
    {
        return Auth::user()?->hasRole(RoleEnum::SUPER_ADMIN->value) ?? false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => ModelsWorkshop::query()
                    ->when(
                        $this->workshopId,
                        fn ($query) => $query->where('id', $this->workshopId)
                    )
                    ->withCount([
                        'registrations' => fn ($query) =>
                            $query->where('status', BookingStatus::CONFIRMED->value),

                        'attendance',
                    ])
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Workshop')
                    ->searchable(),
            
                Tables\Columns\TextColumn::make('registrations_count')
                    ->label('Registered')
                    ->badge(),
            
                Tables\Columns\TextColumn::make('attendance_count')
                    ->label('Attended')
                    ->badge(),
            ])->searchable(false)
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
