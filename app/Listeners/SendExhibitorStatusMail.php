<?php

namespace App\Listeners;

use App\Events\ExhibitorApplicationStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExhibitorApplicationStatusMail;

class SendExhibitorStatusMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ExhibitorApplicationStatusChanged $event): void
    {
        Mail::to($event->application->user->email)->queue(
            new ExhibitorApplicationStatusMail($event->application, $event->statusMessage)
        );
    }
}
