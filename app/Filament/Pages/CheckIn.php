<?php

namespace App\Filament\Pages;

use App\Enums\PermissionEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class CheckIn extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-qr-code';

    protected static ?string $navigationLabel = 'Check-in';

    protected static ?string $title = 'Check-in';


    public static function canAccess(): bool
    {
        return Auth::user()?->can(
            PermissionEnum::PERFORM_CHECK_IN->value
        ) ?? false;
    }


    protected function getHeaderActions(): array
    {
        return [
            Action::make('openCheckIn')
                ->label('Open Check-in')
                ->icon('heroicon-o-qr-code')
                ->action(function () {

                    $token = Auth::user()
                        ->createToken(
                            'check-in-token',
                            [
                                PermissionEnum::PERFORM_CHECK_IN->value
                            ]
                        )
                        ->plainTextToken;


                    return redirect(
                        config('app.frontend_url')
                        . '/check-in?token='
                        . $token
                    );
                }),
        ];
    }
}