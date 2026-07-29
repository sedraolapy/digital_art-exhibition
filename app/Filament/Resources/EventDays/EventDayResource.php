<?php

namespace App\Filament\Resources\EventDays;

use App\Filament\Resources\EventDays\Pages\CreateEventDay;
use App\Filament\Resources\EventDays\Pages\EditEventDay;
use App\Filament\Resources\EventDays\Pages\ListEventDays;
use App\Filament\Resources\EventDays\Pages\ViewEventDay;
use App\Filament\Resources\EventDays\Schemas\EventDayForm;
use App\Filament\Resources\EventDays\Schemas\EventDayInfolist;
use App\Filament\Resources\EventDays\Tables\EventDaysTable;
use App\Models\EventDay;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EventDayResource extends Resource
{
    protected static ?string $model = EventDay::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $recordTitleAttribute = 'day_number';

    protected static string|UnitEnum|null $navigationGroup = 'Event Managment';

    public static function form(Schema $schema): Schema
    {
        return EventDayForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EventDayInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventDaysTable::configure($table);
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
            'index' => ListEventDays::route('/'),
            'create' => CreateEventDay::route('/create'),
            'view' => ViewEventDay::route('/{record}'),
            'edit' => EditEventDay::route('/{record}/edit'),
        ];
    }
}
