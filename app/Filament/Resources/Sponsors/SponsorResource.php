<?php

namespace App\Filament\Resources\Sponsors;

use App\Enums\SponsorType;
use App\Filament\Resources\Sponsors\Pages\CreateSponsor;
use App\Filament\Resources\Sponsors\Pages\EditSponsor;
use App\Filament\Resources\Sponsors\Pages\ListSponsors;
use App\Filament\Resources\Sponsors\Pages\ViewSponsor;
use App\Filament\Resources\Sponsors\Schemas\SponsorForm;
use App\Filament\Resources\Sponsors\Schemas\SponsorInfolist;
use App\Filament\Resources\Sponsors\Tables\SponsorsTable;
use App\Models\Sponsor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SponsorResource extends Resource
{
    protected static ?string $model = Sponsor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return SponsorForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SponsorInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SponsorsTable::configure($table);
    }

    public static function syncTypeRelation($record, array $data): void
{
    if ($record->type === SponsorType::DIAMOND) {
        $record->cycles()->sync(!empty($data['cycle_id']) ? [$data['cycle_id']] : []);
        $record->occurrences()->sync([]);
    } elseif (in_array($record->type, [SponsorType::GOLD, SponsorType::SILVER])) {
        $record->occurrences()->sync(!empty($data['event_occurrence_id']) ? [$data['event_occurrence_id']] : []);
        $record->cycles()->sync([]);
    }
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
            'index' => ListSponsors::route('/'),
            'create' => CreateSponsor::route('/create'),
            'view' => ViewSponsor::route('/{record}'),
            'edit' => EditSponsor::route('/{record}/edit'),
        ];
    }
}
