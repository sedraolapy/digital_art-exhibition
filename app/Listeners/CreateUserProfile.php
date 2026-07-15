<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\UserProfile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateUserProfile
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
    public function handle(UserRegistered $event): void
    {
        $user = $event->user;
        UserProfile::create([
            'user_id' => $user->id,
            'profile_image_url' => null,
        ]);
    }
}
