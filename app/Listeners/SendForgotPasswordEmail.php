<?php

namespace App\Listeners;

use App\Events\ForgotPasswordRequested;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;

class SendForgotPasswordEmail
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
    public function handle(ForgotPasswordRequested $event): void
    {
        Mail::to($event->user->email)->queue(new ForgotPasswordMail($event->user,$event->token));
    }
}
