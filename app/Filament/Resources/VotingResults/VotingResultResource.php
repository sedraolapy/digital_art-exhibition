<?php

namespace App\Filament\Resources\VotingResults;

use App\Filament\Resources\BaseResource;
use App\Filament\Resources\VotingResults\Pages\CreateVotingResult;
use App\Filament\Resources\VotingResults\Pages\EditVotingResult;
use App\Filament\Resources\VotingResults\Pages\ListVotingResults;
use App\Filament\Resources\VotingResults\Pages\ViewVotingResult;
use App\Filament\Resources\VotingResults\Schemas\VotingResultForm;
use App\Filament\Resources\VotingResults\Schemas\VotingResultInfolist;
use App\Filament\Resources\VotingResults\Tables\VotingResultsTable;
use App\Models\VotingResult;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class VotingResultResource extends BaseResource
{
    protected static ?string $model = VotingResult::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTrophy;

    protected static ?string $recordTitleAttribute = 'voting';

    protected static string|UnitEnum|null $navigationGroup = 'Voting Managment';


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->selectRaw('
                MAX(id) as id,
                exhibitor_id,
                event_occurrence_id,
                COUNT(*) as total_votes
            ')
            ->groupBy(
                'exhibitor_id',
                'event_occurrence_id'
            );
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return VotingResultForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VotingResultInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VotingResultsTable::configure($table);
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
            'index' => ListVotingResults::route('/'),
            'create' => CreateVotingResult::route('/create'),
            'view' => ViewVotingResult::route('/{record}'),
            'edit' => EditVotingResult::route('/{record}/edit'),
        ];
    }
}
