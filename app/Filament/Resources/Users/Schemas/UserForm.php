<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\Role;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SimpleSoftwareIO\QrCode\Generator;
use Illuminate\Support\Facades\Crypt;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required(),
                Select::make('role')
                    ->options(Role::class)
                    ->default('user')
                    ->required(),
                Placeholder::make('qr_token')
                    ->label('QR Code')
                    ->columnSpanFull()
                    ->content(function (?object $record): HtmlString|string {
                        if (! $record?->qr_token) {
                            return '';
                        }

                        return new HtmlString(
                            app(Generator::class)
                                ->size(200)
                                ->generate($record->qr_token)
                        );
                    })
                ]);
    }
}
