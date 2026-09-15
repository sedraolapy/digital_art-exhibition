<?php

namespace App\Filament\Resources\Members\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use App\Filament\Forms\Components\WebpMediaLibraryFileUpload;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->hint('Enter the full name in Arabic')
                    ->rule('regex:/^[\p{Arabic}\s]+$/u'),
                TextInput::make('role')
                    ->required(),
                Textarea::make('bio')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('portfolio_url')
                    ->url(),
                WebpMediaLibraryFileUpload::make('image')
                    ->required()
                    ->collection('members')
                    ->image()
                    ->imageCropAspectRatio('1:1')
                    ->imageEditor()
                    ->hint('The image must be square (1:1 ratio)')
                    ->maxSize(1024)
                    ->validationMessages([
                        'max' => 'The image size must not exceed 1 MB.',
                    ]),
                Repeater::make('socialLinks')
                    ->relationship('socialLinks')
                    ->schema([
                        Select::make('platform')
                            ->required()
                            ->label('platform')
                            ->options([
                                'facebook'  => 'Facebook',
                                'instagram' => 'Instagram',
                                'linkedin'  => 'LinkedIn',
                            ]),
                        TextInput::make('url')
                            ->required()
                            ->url()
                            ->label('link'),
                    ])
                    ->label('Social Links')
                    ->columnSpanFull(),
            ]);
    }
}
