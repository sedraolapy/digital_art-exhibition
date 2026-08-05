<?php

namespace App\Filament\Resources\WorkshopRegistrations;

use App\Filament\Resources\BaseResource;
use App\Filament\Resources\WorkshopRegistrations\Pages\CreateWorkshopRegistration;
use App\Filament\Resources\WorkshopRegistrations\Pages\EditWorkshopRegistration;
use App\Filament\Resources\WorkshopRegistrations\Pages\ListWorkshopRegistrations;
use App\Filament\Resources\WorkshopRegistrations\Pages\ViewWorkshopRegistration;
use App\Filament\Resources\WorkshopRegistrations\Schemas\WorkshopRegistrationForm;
use App\Filament\Resources\WorkshopRegistrations\Schemas\WorkshopRegistrationInfolist;
use App\Filament\Resources\WorkshopRegistrations\Tables\WorkshopRegistrationsTable;
use App\Models\WorkshopRegistration;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class WorkshopRegistrationResource extends BaseResource
{
    protected static ?string $model = WorkshopRegistration::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $recordTitleAttribute = 'registration';

    protected static string|UnitEnum|null $navigationGroup = 'Workshop Managment';

    public static function form(Schema $schema): Schema
    {
        return WorkshopRegistrationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WorkshopRegistrationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkshopRegistrationsTable::configure($table);
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
            'index' => ListWorkshopRegistrations::route('/'),
            'create' => CreateWorkshopRegistration::route('/create'),
            'view' => ViewWorkshopRegistration::route('/{record}'),
            'edit' => EditWorkshopRegistration::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
