<?php

namespace App\Filament\Resources\LectureAttendanceReports;

use App\Filament\Resources\LectureAttendanceReports\Pages\CreateLectureAttendanceReport;
use App\Filament\Resources\LectureAttendanceReports\Pages\EditLectureAttendanceReport;
use App\Filament\Resources\LectureAttendanceReports\Pages\ListLectureAttendanceReports;
use App\Filament\Resources\LectureAttendanceReports\Pages\ViewLectureAttendanceReport;
use App\Filament\Resources\LectureAttendanceReports\Schemas\LectureAttendanceReportForm;
use App\Filament\Resources\LectureAttendanceReports\Schemas\LectureAttendanceReportInfolist;
use App\Filament\Resources\LectureAttendanceReports\Tables\LectureAttendanceReportsTable;
use App\Models\Lecture;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Filament\Resources\LectureAttendanceReports\RelationManagers\AttendanceRelationManager;
use UnitEnum;

class LectureAttendanceReportResource extends Resource
{
    protected static ?string $model = Lecture::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckBadge;

    protected static ?string $navigationLabel = 'Lecture Attendance Report';

    protected static ?string $pluralModelLabel = 'Lecture Attendance Report';

    protected static ?string $modelLabel = 'Lecture Attendance Report';

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|UnitEnum|null $navigationGroup = 'Lecture Managment';

    protected static bool $shouldRegisterNavigation = true;

    public static function form(Schema $schema): Schema
    {
        return LectureAttendanceReportForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LectureAttendanceReportInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LectureAttendanceReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            AttendanceRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLectureAttendanceReports::route('/'),
            'view' => ViewLectureAttendanceReport::route('/{record}'),
        ];
    }
}
