<?php

namespace App\Filament\Resources\WorkshopRegistrations\Schemas;

use App\Enums\BookingStatus;
use App\Enums\RoleEnum;
use App\Models\User;
use App\Models\Workshop;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WorkshopRegistrationForm
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
                Select::make('workshop_id')
                    ->label('Workshop')
                    ->relationship(
                        name: 'Workshop',
                        titleAttribute: 'title'
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn (Workshop $record): string =>
                            "{$record->title} - {$record->speaker_name}"
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('status')
                    ->options(BookingStatus::class)
                    ->default('confirmed')
                    ->disabled()
                    ->required(),
            ]);
    }
}
