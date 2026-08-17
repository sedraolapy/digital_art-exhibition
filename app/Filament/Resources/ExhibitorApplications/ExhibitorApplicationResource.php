<?php

namespace App\Filament\Resources\ExhibitorApplications;

use App\Enums\PermissionEnum;
use App\Filament\Resources\BaseResource;
use App\Filament\Resources\ExhibitorApplications\Pages\CreateExhibitorApplication;
use App\Filament\Resources\ExhibitorApplications\Pages\EditExhibitorApplication;
use App\Filament\Resources\ExhibitorApplications\Pages\ListExhibitorApplications;
use App\Filament\Resources\ExhibitorApplications\Pages\ViewExhibitorApplication;
use App\Filament\Resources\ExhibitorApplications\Schemas\ExhibitorApplicationForm;
use App\Filament\Resources\ExhibitorApplications\Schemas\ExhibitorApplicationInfolist;
use App\Filament\Resources\ExhibitorApplications\Tables\ExhibitorApplicationsTable;
use App\Models\ExhibitorApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use UnitEnum;
use Illuminate\Database\Eloquent\Builder;

class ExhibitorApplicationResource extends BaseResource
{
    protected static ?string $model = ExhibitorApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $recordTitleAttribute = 'Exhibitor Application';

    protected static string|UnitEnum|null $navigationGroup = 'Users Managment';

    protected static function canAccessByPermission(): bool
    {
        return Auth::user()?->can(
            PermissionEnum::VIEW_EXHIBITOR_APPLICATIONS->value
        ) ?? false;
    }


    public static function canCreate(): bool
    {
        return Auth::user()?->can(
            PermissionEnum::CREATE_EXHIBITOR_APPLICATIONS->value
        ) ?? false;
    }

    public static function canDelete($record): bool
    {
        return Auth::user()?->can(
            PermissionEnum::DELETE_EXHIBITOR_APPLICATIONS->value
        ) ?? false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'category', 'media']);
    }

    public static function form(Schema $schema): Schema
    {
        return ExhibitorApplicationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExhibitorApplicationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExhibitorApplicationsTable::configure($table);
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
            'index' => ListExhibitorApplications::route('/'),
            'create' => CreateExhibitorApplication::route('/create'),
            'view' => ViewExhibitorApplication::route('/{record}'),
            'edit' => EditExhibitorApplication::route('/{record}/edit'),
        ];
    }
}
