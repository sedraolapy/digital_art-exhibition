<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('first_name')
                    ->label('First Name')
                    ->rule('regex:/^[\p{Arabic}\s]+$/u')
                    ->required(),

                TextInput::make('last_name')
                    ->label('Last Name')
                    ->rule('regex:/^[\p{Arabic}\s]+$/u')
                    ->required(),

                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required(),

                TextInput::make('phone')
                    ->tel()
                    ->required(),

                TextInput::make('instagram')
                    ->label('Instagram')
                    ->url()
                    ->requiredWithout('facebook')
                    ->afterStateHydrated(function ($component, $record) {
                        $component->state(
                            $record?->userProfile
                                ?->socialLinks()
                                ->where('platform', 'instagram')
                                ->value('url')
                        );
                    }),

                TextInput::make('facebook')
                    ->label('Facebook')
                    ->url()
                    ->requiredWithout('instagram')
                    ->afterStateHydrated(function ($component, $record) {
                        $component->state(
                            $record?->userProfile
                                ?->socialLinks()
                                ->where('platform', 'facebook')
                                ->value('url')
                        );
                    }),

                TextInput::make('qr_token')
                    ->label('QR Token')
                    ->disabled()
                    ->default(fn () => Str::uuid()->toString())
                    ->dehydrated()
                    ->afterStateHydrated(function ($component, $record) {
                        if ($record) {
                            $component->state($record->qr_token);
                        }
                    })
                    ->suffixAction(
                        Action::make('generateQrToken')
                            ->label('Generate New Token')
                            ->icon('heroicon-o-arrow-path')
                            ->action(function ($set) {
                                $set('qr_token', Str::uuid()->toString());
                            })
                    ),

                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->minLength(8)
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),

                Section::make('Profile')
                    ->relationship('userProfile')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('image')
                            ->collection('user_image')
                            ->image()
                            ->imageCropAspectRatio('1:1')
                            ->imageEditor()
                            ->hint('The image must be square (1:1 ratio)')
                            ->maxSize(1024)
                            ->validationMessages([
                                'max' => 'The image size must not exceed 1 MB.',
                            ])
                            ->preserveFilenames(),
                    ]),
            ]);
    }
}