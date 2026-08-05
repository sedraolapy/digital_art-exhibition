<?php

namespace App\Filament\Resources\LectureAttendances;

use App\Filament\Resources\BaseResource;
use App\Filament\Resources\LectureAttendances\Pages\CreateLectureAttendance;
use App\Filament\Resources\LectureAttendances\Pages\EditLectureAttendance;
use App\Filament\Resources\LectureAttendances\Pages\ListLectureAttendances;
use App\Filament\Resources\LectureAttendances\Pages\ViewLectureAttendance;
use App\Filament\Resources\LectureAttendances\Schemas\LectureAttendanceForm;
use App\Filament\Resources\LectureAttendances\Schemas\LectureAttendanceInfolist;
use App\Filament\Resources\LectureAttendances\Tables\LectureAttendancesTable;
use App\Models\LectureAttendance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LectureAttendanceResource extends BaseResource
{
    protected static ?string $model = LectureAttendance::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    protected static ?string $recordTitleAttribute = 'attendance';

    protected static string|UnitEnum|null $navigationGroup = 'Lecture Managment';

    public static function form(Schema $schema): Schema
    {
        return LectureAttendanceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LectureAttendanceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LectureAttendancesTable::configure($table);
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
            'index' => ListLectureAttendances::route('/'),
            'create' => CreateLectureAttendance::route('/create'),
            'view' => ViewLectureAttendance::route('/{record}'),
            'edit' => EditLectureAttendance::route('/{record}/edit'),
        ];
    }
}
