<?php

namespace App\Filament\Resources\ExhibitorApplications;

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
use UnitEnum;

class ExhibitorApplicationResource extends Resource
{
    protected static ?string $model = ExhibitorApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $recordTitleAttribute = 'Exhibitor Application';

    protected static string|UnitEnum|null $navigationGroup = 'Users Managment';

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
