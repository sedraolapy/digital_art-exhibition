<?php

namespace App\Filament\Resources\EventAttendances;

use App\Filament\Resources\EventAttendances\Pages\CreateEventAttendance;
use App\Filament\Resources\EventAttendances\Pages\EditEventAttendance;
use App\Filament\Resources\EventAttendances\Pages\ListEventAttendances;
use App\Filament\Resources\EventAttendances\Pages\ViewEventAttendance;
use App\Filament\Resources\EventAttendances\Schemas\EventAttendanceForm;
use App\Filament\Resources\EventAttendances\Schemas\EventAttendanceInfolist;
use App\Filament\Resources\EventAttendances\Tables\EventAttendancesTable;
use App\Models\EventAttendance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EventAttendanceResource extends Resource
{
    protected static ?string $model = EventAttendance::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|UnitEnum|null $navigationGroup = 'Event Managment';

    public static function form(Schema $schema): Schema
    {
        return EventAttendanceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EventAttendanceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventAttendancesTable::configure($table);
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
            'index' => ListEventAttendances::route('/'),
            'create' => CreateEventAttendance::route('/create'),
            'view' => ViewEventAttendance::route('/{record}'),
            'edit' => EditEventAttendance::route('/{record}/edit'),
        ];
    }
}
