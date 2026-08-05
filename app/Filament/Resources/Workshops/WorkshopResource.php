<?php

namespace App\Filament\Resources\Workshops;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Filament\Resources\BaseResource;
use App\Filament\Resources\Workshops\Pages\CreateWorkshop;
use App\Filament\Resources\Workshops\Pages\EditWorkshop;
use App\Filament\Resources\Workshops\Pages\ListWorkshops;
use App\Filament\Resources\Workshops\Pages\ViewWorkshop;
use App\Filament\Resources\Workshops\Schemas\WorkshopForm;
use App\Filament\Resources\Workshops\Schemas\WorkshopInfolist;
use App\Filament\Resources\Workshops\Tables\WorkshopsTable;
use App\Models\Workshop;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class WorkshopResource extends BaseResource
{
    protected static ?string $model = Workshop::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|UnitEnum|null $navigationGroup = 'Workshop Managment';

    protected static function canAccessByPermission(): bool
    {
        return Auth::user()?->can(
            PermissionEnum::VIEW_WORKSHOP->value
        ) ?? false;
    }

    public static function canEdit($record): bool
    {
        return Auth::user()?->can(
            PermissionEnum::UPDATE_WORKSHOP->value
        ) ?? false;
    }


    public static function form(Schema $schema): Schema
    {
        return WorkshopForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WorkshopInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkshopsTable::configure($table);
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
            'index' => ListWorkshops::route('/'),
            'create' => CreateWorkshop::route('/create'),
            'view' => ViewWorkshop::route('/{record}'),
            'edit' => EditWorkshop::route('/{record}/edit'),
        ];
    }
}
