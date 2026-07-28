<?php

namespace App\Filament\Resources\AdminUsers\Schemas;

use App\Enums\RoleEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AdminUserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('first_name')
                    ->label('First Name')
                    ->required(),

                TextInput::make('last_name')
                    ->label('Last Name')
                    ->required(),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->unique()
                    ->required(),

                TextInput::make('phone')
                    ->label('Phone')
                    ->tel()
                    ->required(),

                    Select::make('role')
                    ->label('Role')
                    ->options([
                        RoleEnum::CONTENT_MANAGER->value => 'Content Manager',
                        RoleEnum::EXHIBITOR_APPLICATION_MANAGER->value => 'Exhibitor Application Manager',
                        RoleEnum::ORGANIZER->value => 'Organizer',
                    ])
                    ->required()
                    ->dehydrated()
                    ->afterStateHydrated(function ($component, $record) {

                        if ($record) {
                            $component->state(
                                $record->getRoleNames()->first()
                            );
                        }

                    }),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->minLength(8)
                    ->required(fn ($operation) => $operation === 'create')
                    ->dehydrated(fn ($state) => filled($state)),

            ]);
    }
}