<?php

namespace App\Filament\Resources\WorkshopAttendanceReports;

use App\Filament\Resources\BaseResource;
use App\Filament\Resources\WorkshopAttendanceReports\Pages\CreateWorkshopAttendanceReport;
use App\Filament\Resources\WorkshopAttendanceReports\Pages\EditWorkshopAttendanceReport;
use App\Filament\Resources\WorkshopAttendanceReports\Pages\ListWorkshopAttendanceReports;
use App\Filament\Resources\WorkshopAttendanceReports\Pages\ViewWorkshopAttendanceReport;
use App\Filament\Resources\WorkshopAttendanceReports\RelationManagers\AttendanceRelationManager;
use App\Filament\Resources\WorkshopAttendanceReports\Schemas\WorkshopAttendanceReportForm;
use App\Filament\Resources\WorkshopAttendanceReports\Schemas\WorkshopAttendanceReportInfolist;
use App\Filament\Resources\WorkshopAttendanceReports\Tables\WorkshopAttendanceReportsTable;
use App\Models\Workshop;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class WorkshopAttendanceReportResource extends BaseResource
{
    protected static ?string $model = Workshop::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckBadge;

    protected static string|UnitEnum|null $navigationGroup = 'Workshop Managment';


    protected static ?string $navigationLabel = 'Workshop Attendance Report';

    protected static ?string $pluralModelLabel = 'Workshop Attendance Report';

    protected static ?string $modelLabel = 'Workshop Attendance Report';

    protected static ?string $recordTitleAttribute = 'Attendances';

    public static function form(Schema $schema): Schema
    {
        return WorkshopAttendanceReportForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WorkshopAttendanceReportInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkshopAttendanceReportsTable::configure($table);
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
            'index' => ListWorkshopAttendanceReports::route('/'),
            'create' => CreateWorkshopAttendanceReport::route('/create'),
            'view' => ViewWorkshopAttendanceReport::route('/{record}'),
            'edit' => EditWorkshopAttendanceReport::route('/{record}/edit'),
        ];
    }
}
