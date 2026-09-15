<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\RoleEnum;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
                TextEntry::make('phone'),
                TextEntry::make('role')
                    ->label('Role')
                    ->badge()
                    ->state(fn ($record) =>
                        $record->getRoleNames()->first()
                    ),
                ImageEntry::make('image')
                    ->label('Image')
                    ->size(150)
                    ->state(function ($record) {
                        return $record->userProfile->getFirstMediaUrl('user_image')?: null;
                    })
                    ->url(fn ($state) => $state)
                    ->openUrlInNewTab(),
                ImageEntry::make('qr_code')
                    ->label('QR Code')
                    ->state(function ($record) {

                        if (! $record->qr_token) {
                            return null;
                        }

                        return 'data:image/svg+xml;base64,' . base64_encode(
                            QrCode::format('svg')
                                ->size(150)
                                ->generate($record->qr_token)
                        );
                    })
                    ->size(150),
                RepeatableEntry::make('socialLinks')
                    ->label('Social Links')
                    ->state(function ($record) {
                        return $record->userProfile
                            ?->socialLinks()
                            ->get()
                            ->toArray() ?? [];
                    })
                    ->schema([
                        TextEntry::make('platform')
                            ->label('Platform')
                            ->badge(),
                
                        TextEntry::make('url')
                            ->label('Link')
                            ->url(fn ($state) => $state)
                            ->openUrlInNewTab()
                            ->formatStateUsing(fn () => 'Visit Profile')
                            ->icon('heroicon-o-link'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
