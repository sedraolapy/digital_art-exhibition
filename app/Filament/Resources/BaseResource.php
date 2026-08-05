<?php

namespace App\Filament\Resources;

use App\Enums\RoleEnum;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;

abstract class BaseResource extends Resource
{
    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        // Super Admin bypass
        if ($user->hasRole(RoleEnum::SUPER_ADMIN->value)) {
            return true;
        }

        return static::canAccessByPermission();
    }

    protected static function canAccessByPermission(): bool
    {
        return false;
    }

    public static function canCreate(): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        if ($user->hasRole(RoleEnum::SUPER_ADMIN->value)) {
            return true;
        }

        return false;
    }

    public static function canDelete($record): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        if ($user->hasRole(RoleEnum::SUPER_ADMIN->value)) {
            return true;
        }
        
        return false;
    }
}