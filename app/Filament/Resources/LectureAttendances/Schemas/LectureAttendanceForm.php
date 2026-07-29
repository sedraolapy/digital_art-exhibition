<?php

namespace App\Filament\Resources\LectureAttendances\Schemas;

use App\Enums\RoleEnum;
use App\Models\Lecture;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LectureAttendanceForm
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
                Select::make('lecture_id')
                    ->label('Lecture')
                    ->relationship(
                        name: 'lecture',
                        titleAttribute: 'title'
                    )
                    ->getOptionLabelFromRecordUsing(
                        fn (Lecture $record): string =>
                            "{$record->title} - {$record->speaker_name}"
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
