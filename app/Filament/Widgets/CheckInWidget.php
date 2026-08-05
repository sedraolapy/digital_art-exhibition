<?php

namespace App\Filament\Widgets;

use App\Enums\PermissionEnum;
use App\Models\CheckInSession;
use App\Models\EventOccurrence;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Schema;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Filament\Forms\Contracts\HasForms;

class CheckInWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.widgets.check-in-widget';


    public ?array $data = [];


    public static function canView(): bool
    {
        return Auth::user()->can(PermissionEnum::PERFORM_CHECK_IN->value);
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Select::make('type')
                    ->label('Check-in Type')
                    ->options([
                        'event' => 'Event',
                        'workshop' => 'Workshop',
                    ])
                    ->required()
                    ->live(),

                Select::make('eventOccurrenceId')
                    ->label('Event')
                    ->options(EventOccurrence::pluck('title', 'id'))
                    ->visible(fn ($get) => $get('type') === 'event')
                    ->required(fn ($get) => $get('type') === 'event'),
            ]);
    }

    public function openCheckIn(): void
    {
        $data = $this->form->getState();

        $token = Str::random(64);

        CheckInSession::create([
            'user_id' => Auth::id(),
            'event_occurrence_id' => $data['type'] === 'event'
                ? $data['eventOccurrenceId']
                : null,
            'token_hash' => hash('sha256', $token),
            'expires_at' => now()->addHour(),
        ]);

        redirect(
            config('app.frontend_url') . '/check-in?session=' . $token
        );
    }
}