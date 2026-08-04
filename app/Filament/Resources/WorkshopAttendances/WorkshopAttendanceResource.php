<?php

namespace App\Filament\Resources\WorkshopAttendances;

use App\Filament\Resources\WorkshopAttendances\Pages\CreateWorkshopAttendance;
use App\Filament\Resources\WorkshopAttendances\Pages\EditWorkshopAttendance;
use App\Filament\Resources\WorkshopAttendances\Pages\ListWorkshopAttendances;
use App\Filament\Resources\WorkshopAttendances\Pages\ViewWorkshopAttendance;
use App\Filament\Resources\WorkshopAttendances\Schemas\WorkshopAttendanceForm;
use App\Filament\Resources\WorkshopAttendances\Schemas\WorkshopAttendanceInfolist;
use App\Filament\Resources\WorkshopAttendances\Tables\WorkshopAttendancesTable;
use App\Models\WorkshopAttendance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class WorkshopAttendanceResource extends Resource
{
    protected static ?string $model = WorkshopAttendance::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    protected static ?string $recordTitleAttribute = 'Attendance';

    protected static string|UnitEnum|null $navigationGroup = 'Workshop Managment';

    public static function form(Schema $schema): Schema
    {
        return WorkshopAttendanceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WorkshopAttendanceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkshopAttendancesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWorkshopAttendances::route('/'),
            'create' => CreateWorkshopAttendance::route('/create'),
            'view' => ViewWorkshopAttendance::route('/{record}'),
            'edit' => EditWorkshopAttendance::route('/{record}/edit'),
        ];
    }
}
