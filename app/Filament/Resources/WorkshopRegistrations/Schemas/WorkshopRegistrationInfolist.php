<?php

namespace App\Filament\Resources\WorkshopRegistrations\Schemas;

use App\Enums\BookingStatus;
use App\Models\WorkshopRegistration;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class WorkshopRegistrationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User name'),
                TextEntry::make('workshop.title')
                    ->label('Workshop'),
                TextEntry::make('status')
                    ->badge()
                    ->color(function ($state, $record) {
                        return match ($state) {
                            BookingStatus::CONFIRMED => 'success',
                            BookingStatus::CANCELLED => 'danger',
                        };
                    }),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                    TextEntry::make('deleted_at')
                    ->dateTime()
                    ->color('danger')
                    ->visible(fn (WorkshopRegistration $record): bool => $record->trashed()),
            ]);
    }
}
