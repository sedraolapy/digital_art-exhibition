<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Generator;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('first_name'),
                TextEntry::make('last_name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('phone'),
                TextEntry::make('role')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('qr_token')
                    ->label('QR Code')
                    ->html()
                    ->state(function (?object $record): HtmlString|string {
                        if (! $record?->qr_token) {
                            return '';
                        }

                        return new HtmlString(
                            app(Generator::class)
                                ->size(200)
                                ->generate($record->qr_token)
                        );
                    }),
            ]);
    }
}
