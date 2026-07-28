<?php

namespace App\Filament\Resources\AdminUsers\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AdminUserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('first_name'),
                TextEntry::make('last_name'),
                TextEntry::make('email')
                    ->label('Email'),
                TextEntry::make('phone')
                    ->label('Phone'),

                TextEntry::make('role')
                    ->label('Role')
                    ->badge()
                    ->state(fn ($record) =>
                        $record->getRoleNames()->first()
                    )
                    ->formatStateUsing(fn ($state) =>
                        ucwords(str_replace('_', ' ', $state))
                    ),

                TextEntry::make('created_at')
                    ->label('Created At')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Updated At')
                    ->dateTime(),

            ]);
    }
}