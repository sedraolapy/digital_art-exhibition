<?php

namespace App\Filament\Resources\Votes\Schemas;

use App\Enums\RoleEnum;
use App\Models\ExhibitorProfile;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class VoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('User')
                    ->relationship(
                        name: 'user',
                        titleAttribute: 'first_name',
                        modifyQueryUsing: fn ($query) => $query
                            ->whereHas('roles', function ($q) {
                                $q->whereIn('name', [
                                    RoleEnum::USER->value,
                                    RoleEnum::EXHIBITOR->value,
                                ]);
                            })
                            ->orderBy('first_name')
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn (User $record): string => sprintf(
                            '%s %s (%s)',
                            $record->first_name,
                            $record->last_name,
                            $record->hasRole(RoleEnum::EXHIBITOR->value)
                                ? 'Exhibitor'
                                : 'User'
                        )
                    )
                    ->searchable(['first_name', 'last_name', 'email'])
                    ->preload()
                    ->required(),
                Select::make('exhibitor_id')
                    ->label('Exhibitor')
                    ->relationship(
                        name: 'exhibitor',
                        titleAttribute: 'id',
                        modifyQueryUsing: fn ($query) => $query
                            ->with('user')
                            ->orderBy('user_id')
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn (ExhibitorProfile $record): string =>
                            "{$record->user->first_name} {$record->user->last_name}"
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('event_occurrence_id')
                    ->relationship('eventOccurrence', 'title')
                    ->required(),
            ]);
    }
}
