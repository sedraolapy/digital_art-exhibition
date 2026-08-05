<?php

namespace App\Filament\Resources\EventOccurrences;

use App\Filament\Resources\BaseResource;
use App\Filament\Resources\EventOccurrences\Pages\CreateEventOccurrence;
use App\Filament\Resources\EventOccurrences\Pages\EditEventOccurrence;
use App\Filament\Resources\EventOccurrences\Pages\ListEventOccurrences;
use App\Filament\Resources\EventOccurrences\Pages\ViewEventOccurrence;
use App\Filament\Resources\EventOccurrences\RelationManagers\DaysRelationManager;
use App\Filament\Resources\EventOccurrences\Schemas\EventOccurrenceForm;
use App\Filament\Resources\EventOccurrences\Schemas\EventOccurrenceInfolist;
use App\Filament\Resources\EventOccurrences\Tables\EventOccurrencesTable;
use App\Models\EventOccurrence;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EventOccurrenceResource extends BaseResource
{
    protected static ?string $model = EventOccurrence::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|UnitEnum|null $navigationGroup = 'Event Managment';

    public static function form(Schema $schema): Schema
    {
        return EventOccurrenceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EventOccurrenceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventOccurrencesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            DaysRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEventOccurrences::route('/'),
            'create' => CreateEventOccurrence::route('/create'),
            'view' => ViewEventOccurrence::route('/{record}'),
            'edit' => EditEventOccurrence::route('/{record}/edit'),
        ];
    }
}
