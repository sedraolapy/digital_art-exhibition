<?php

namespace App\Filament\Resources\Members\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->hint('يرجى إدخال الاسم الكامل باللغة العربية')
                    ->rule('regex:/^[\p{Arabic}\s]+$/u'),
                TextInput::make('role')
                    ->required(),
                Textarea::make('bio')
                    ->required()
                    ->rule('regex:/^[\p{Arabic}\s]+$/u')
                    ->columnSpanFull(),
                TextInput::make('portfolio_url')
                    ->url(),
                SpatieMediaLibraryFileUpload::make('image')
                    ->required()
                    ->collection('members')
                    ->image()
                    ->maxSize(1024)
                    ->validationMessages([
                        'max' => 'The image size must not exceed 1 MB.',
                    ])
                    ->preserveFilenames(),
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
