<?php

namespace App\Filament\Resources\EventAttendanceReports;

use App\Filament\Resources\EventAttendanceReports\Pages\CreateEventAttendanceReport;
use App\Filament\Resources\EventAttendanceReports\Pages\EditEventAttendanceReport;
use App\Filament\Resources\EventAttendanceReports\Pages\ListEventAttendanceReports;
use App\Filament\Resources\EventAttendanceReports\Pages\ViewEventAttendanceReport;
use App\Filament\Resources\EventAttendanceReports\RelationManagers\AttendancesRelationManager;
use App\Filament\Resources\EventAttendanceReports\Schemas\EventAttendanceReportForm;
use App\Filament\Resources\EventAttendanceReports\Schemas\EventAttendanceReportInfolist;
use App\Filament\Resources\EventAttendanceReports\Tables\EventAttendanceReportsTable;
use App\Models\EventAttendanceReport;
use App\Models\EventDay;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EventAttendanceReportResource extends Resource
{
    protected static ?string $model = EventDay::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckBadge;

    protected static ?string $navigationLabel = 'Event Attendance Report';

    protected static ?string $pluralModelLabel = 'Event Attendance Report';

    protected static ?string $modelLabel = 'Event Attendance Report';

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|UnitEnum|null $navigationGroup = 'Event Managment';

    public static function form(Schema $schema): Schema
    {
        return EventAttendanceReportForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EventAttendanceReportInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventAttendanceReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            AttendancesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEventAttendanceReports::route('/'),
            'create' => CreateEventAttendanceReport::route('/create'),
            'view' => ViewEventAttendanceReport::route('/{record}'),
            'edit' => EditEventAttendanceReport::route('/{record}/edit'),
        ];
    }
}
