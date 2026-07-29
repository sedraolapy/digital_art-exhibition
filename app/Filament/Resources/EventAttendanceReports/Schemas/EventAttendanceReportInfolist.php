<?php

namespace App\Filament\Resources\EventAttendanceReports\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EventAttendanceReportInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('day_number')
                    ->label('Event Day')
                    ->badge(),

                TextEntry::make('occurrence.title')
                    ->label('Event'),

                TextEntry::make('date')
                    ->label('Date')
                    ->date(),

                TextEntry::make('attendances_count')
                    ->label('Total Attendance')
                    ->getStateUsing(
                        fn ($record) => $record->attendances()->count()
                    )
                    ->badge(),
            ]);
    }
}
