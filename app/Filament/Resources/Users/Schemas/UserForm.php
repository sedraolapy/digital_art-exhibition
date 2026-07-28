<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\RoleEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
                    ->required(),

                TextInput::make('phone')
                    ->tel()
                    ->required(),

                Select::make('role')
                    ->label('Role')
                    ->options([
                        RoleEnum::USER->value => 'User',
                        RoleEnum::EXHIBITOR->value => 'Exhibitor',
                    ])
                    ->required()
                    ->dehydrated(false)
                    ->afterStateHydrated(function ($component, $record) {
                        $component->state(
                            $record?->getRoleNames()->first()
                        );
                    }),

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