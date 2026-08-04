<?php

namespace App\Filament\Resources\WorkshopAttendanceReports\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class WorkshopAttendanceReportInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')
                    ->label('Workshop')
                    ->url(fn ($record) => route(
                        'filament.admin.resources.workshops.view',
                        $record
                    ))
                    ->color('primary')
                    ->weight('medium')
                    ->icon('heroicon-o-link')
                    ->iconPosition('before'),

                TextEntry::make('attendance_count')
                    ->label('Total Attendance')
                    ->getStateUsing(
                        fn ($record) => $record->attendance()->count()
                    )
                    ->badge(),
            ]);
    }
}
