<?php

namespace App\Filament\Resources\LectureAttendanceReports\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LectureAttendanceReportInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextEntry::make('title')
                    ->label('Lecture')
                    ->url(fn ($record) => route(
                        'filament.admin.resources.lectures.view',
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