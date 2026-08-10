<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\RoleEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
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
                ->rule('regex:/^[\p{Arabic}\s]+$/u')
                    ->label('Last Name')
                    ->required(),

                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->unique()
                    ->required(),

                TextInput::make('phone')
                    ->tel()
                    ->required(),

                TextInput::make('instagram')
                    ->label('Instagram')
                    ->url()
                    ->requiredWithout('facebook')
                    ->afterStateHydrated(function ($component, $record) {
                        if (! $record) {
                            return;
                        }
                
                        $component->state(
                            $record->socialLinks()
                                ->where('platform', 'instagram')
                                ->value('url')
                        );
                    }),
                
                TextInput::make('facebook')
                    ->label('Facebook')
                    ->url()
                    ->requiredWithout('instagram')
                    ->afterStateHydrated(function ($component, $record) {
                        if (! $record) {
                            return;
                        }
                
                        $component->state(
                            $record->socialLinks()
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

                SpatieMediaLibraryFileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->imageCropAspectRatio('1:1')
                    ->imageEditor()
                    ->hint('The image must be square (1:1 ratio)')
                    ->maxSize(1024)
                    ->validationMessages([
                        'max' => 'The image size must not exceed 1 MB.',
                    ])
                    ->preserveFilenames()
                    ->collection(fn ($record) =>
                        $record?->hasRole(RoleEnum::EXHIBITOR->value)
                            ? 'exhibitor_image'
                            : 'user_image'
                    )
                    ->maxSize(2048),

                TextInput::make('password')
                    ->password()
                    ->minLength(8)
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),

            ]);
    }
}