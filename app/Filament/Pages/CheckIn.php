<?php

namespace App\Filament\Pages;

use App\Models\CheckInSession;
use App\Models\EventOccurrence;
use Auth;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Illuminate\Support\Str;


class CheckIn extends Page
{
    use InteractsWithForms;


    protected string $view = 'filament.pages.check-in';


    public ?array $data = [];


    public function mount(): void
    {
        $this->form->fill();
    }


    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([

                Select::make('eventOccurrenceId')
                    ->label('Select Event')
                    ->options(
                        EventOccurrence::query()
                            ->pluck('title', 'id')
                    )
                    ->searchable()
                    ->live(),

            ]);
    }


    protected function getHeaderActions(): array
    {
        return [

            Action::make('openCheckIn')
                ->label('Open Check-in')
                ->icon('heroicon-o-qr-code')
                ->action(function () {

                    $data = $this->form->getState();
                    $token = Str::random(64);
                    $session = CheckInSession::create([
                        'user_id' => Auth::id(),
                        'event_occurrence_id' => $data['eventOccurrenceId'],
                        'token_hash' => hash('sha256', $token),
                        'expires_at' => now()->addHours(1),
                    ]);
                    return redirect(
                        config('app.frontend_url')
                        . '/check-in?session='
                        . $token
                    );

                }),
        ];
    }

}