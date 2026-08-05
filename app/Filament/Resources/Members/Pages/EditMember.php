<?php

namespace App\Filament\Resources\Members\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\Members\MemberResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditMember extends EditRecord
{
    protected static string $resource = MemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                ->visible(fn () => Auth::user()->hasRole(RoleEnum::SUPER_ADMIN->value)),
        ];
    }
}
