<?php

namespace App\Filament\Pages;

use App\Enums\RoleEnum;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class Logs extends Page
{
    protected string $view = 'filament.pages.logs';

    protected static ?string $title = 'System Logs';

    protected static ?string $navigationLabel = 'Logs';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }

    public static function canAccess(): bool
    {
        return Auth::user()?->hasRole(RoleEnum::SUPER_ADMIN->value) ?? false;
    }

    public string $channel = 'security';

    public ?string $date = null;

    public string $search = '';

    public function mount(): void
    {
        $this->date = now()->format('Y-m-d');
    }

    public function getLogContent(): string
    {
        $path = storage_path(
            "logs/{$this->channel}-{$this->date}.log"
        );

        if (! File::exists($path)) {
            return 'No logs found for this date.';
        }

        return File::get($path);
    }
}