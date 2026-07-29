<?php

namespace App\Filament\Resources\EventAttendances\Schemas;

use App\Enums\RoleEnum;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EventAttendanceForm
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
                    Select::make('event_day_id')
                    ->label('Event Day')
                    ->relationship(
                        name: 'eventDay',
                        titleAttribute: 'day_number'
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn ($record): string =>
                            "{$record->day_number} - {$record->occurrence->title}"
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
