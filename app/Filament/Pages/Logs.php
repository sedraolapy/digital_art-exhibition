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

    public string $date;

    public string $search = '';

    public ?string $level = null;

    public function mount(): void
    {
        $this->date = now()->format('Y-m-d');
    }

    public function getLogs(): array
    {
        $path = storage_path(
            "logs/{$this->channel}-{$this->date}.log"
        );

        if (! File::exists($path)) {
            return [];
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $logs = [];

        foreach ($lines as $line) {

            if (! preg_match(
                '/^\[(.*?)\]\s+\S+\.(\w+):\s+(.*)$/',
                $line,
                $matches
            )) {
                continue;
            }

            $datetime = $matches[1];
            $level = strtoupper($matches[2]);
            $content = $matches[3];

            $context = [];

            if (preg_match('/^(.*?)\s+(\{.*\})$/', $content, $parts)) {
                $message = $parts[1];

                $decoded = json_decode($parts[2], true);

                if (is_array($decoded)) {
                    $context = $decoded;
                }
            } else {
                $message = $content;
            }

            if ($this->level && $level !== strtoupper($this->level)) {
                continue;
            }

            if (
                $this->search &&
                ! str_contains(
                    strtolower($line),
                    strtolower($this->search)
                )
            ) {
                continue;
            }

            $logs[] = [
                'datetime' => $datetime,
                'level' => $level,
                'message' => $message,
                'context' => $context,
            ];
        }

        return array_reverse($logs);
    }
}
