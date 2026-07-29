<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BookingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User name'),
                TextEntry::make('lecture.title')
                    ->label('Lecture'),
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
                    ->visible(fn (Booking $record): bool => $record->trashed()),
            ]);
    }
}
