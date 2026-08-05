<?php

namespace App\Filament\Resources\ExhibitorProfiles;

use App\Enums\PermissionEnum;
use App\Filament\Resources\BaseResource;
use App\Filament\Resources\ExhibitorProfiles\Pages\CreateExhibitorProfile;
use App\Filament\Resources\ExhibitorProfiles\Pages\EditExhibitorProfile;
use App\Filament\Resources\ExhibitorProfiles\Pages\ListExhibitorProfiles;
use App\Filament\Resources\ExhibitorProfiles\Pages\ViewExhibitorProfile;
use App\Filament\Resources\ExhibitorProfiles\Schemas\ExhibitorProfileForm;
use App\Filament\Resources\ExhibitorProfiles\Schemas\ExhibitorProfileInfolist;
use App\Filament\Resources\ExhibitorProfiles\Tables\ExhibitorProfilesTable;
use App\Models\ExhibitorProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class ExhibitorProfileResource extends BaseResource
{
    protected static ?string $model = ExhibitorProfile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    protected static ?string $recordTitleAttribute = 'Exhibitor';

    protected static string|UnitEnum|null $navigationGroup = 'Users Managment';

    protected static function canAccessByPermission(): bool
    {
        return Auth::user()?->can(
            PermissionEnum::VIEW_EXHIBITOR_PROFILES->value
        ) ?? false;
    }

    public static function canEdit($record): bool
    {
        return Auth::user()?->can(
            PermissionEnum::UPDATE_EXHIBITOR_PROFILES->value
        ) ?? false;
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can(
            PermissionEnum::CREATE_EXHIBITOR_PROFILES->value
        ) ?? false;
    }

    public static function canDelete($record): bool
    {
        return Auth::user()?->can(
            PermissionEnum::DELETE_EXHIBITOR_PROFILES->value
        ) ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return ExhibitorProfileForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExhibitorProfileInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExhibitorProfilesTable::configure($table);
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
            'index' => ListExhibitorProfiles::route('/'),
            'create' => CreateExhibitorProfile::route('/create'),
            'view' => ViewExhibitorProfile::route('/{record}'),
            'edit' => EditExhibitorProfile::route('/{record}/edit'),
        ];
    }
}
