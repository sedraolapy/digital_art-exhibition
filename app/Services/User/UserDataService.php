<?php

namespace App\Services\User;

use App\Models\EventOccurrence;
use App\Models\User;
use App\Services\Lecture\BookingService;
use App\Services\CheckIn\CheckInService;
use App\Services\Event\EventService;
use App\Models\ExhibitorApplication;
use App\Services\Exhibitor\VoteService;
use App\Services\Workshop\WorkshopRegistrationService;

class UserDataService
{
    public function __construct(
        private VoteService $voteService,
        private BookingService $bookingService,
        private CheckInService $checkInService,
        private EventService $eventService,
        private WorkshopRegistrationService $registrationService,
    ) {}


    public function loadAuthData(User $user): User
    {
        $activeEvent = $this->eventService->getActiveEvent();

        $this->attachEventContext($user, $activeEvent);

        $user->loadMissing(['userProfile','exhibitorProfiles']);

        $user->is_checked_in = $activeEvent
            ? $this->checkInService->hasCheckedIn($user, $activeEvent)
            : false;

        return $user;
    }

    public function attachEventContext(User $user,?EventOccurrence $event = null): User
    {

        $userId = $user->id;

        $user->current_event = $event
            ? [
                'id' => $event->id,
                'title' => $event->title,
            ]
            : null;

        $user->voted_exhibitors =
            $this->voteService->getUserVotesForActiveOccurrence($userId);

        $user->bookings =
            $this->bookingService->getUserConfirmedBookings($userId);

        $user->registrations  =
            $this->registrationService->getUserConfirmedRegisterations($userId);

            $user->exhibitor_application_status = $event
            ? ExhibitorApplication::where('user_id', $userId)
                ->where('event_occurrence_id', $event->id)
                ->value('status')
            : null;

        $user->loadMissing([
            'exhibitorProfiles.eventOccurrence.location',
            'exhibitorProfiles.category',
            'userProfile.socialLinks',
        ]);

        $user->exhibitor_events = $user->exhibitorProfiles;
        return $user;
    }

}
