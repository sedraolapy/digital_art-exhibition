<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\Booking\BookingService;
use App\Services\CheckIn\CheckInService;
use App\Services\Event\EventService;
use App\Services\Exhibitor\ExhibitorApplicationService;
use App\Services\Exhibitor\VoteService;


class UserDataService
{
    public function __construct(
        private VoteService $voteService,
        private BookingService $bookingService,
        private CheckInService $checkInService,
        private EventService $eventService,
        private ExhibitorApplicationService $applicationService,
    ) {}


    public function loadAuthData(User $user): User
    {
        $this->attachEventContext($user);

        $user->loadMissing('socialLinks');

        $user->is_checked_in = $this->checkInService->hasCheckedIn($user);

        return $user;
    }

    public function attachEventContext(User $user): User
    {
        $userId = $user->id;
        $event = $this->eventService->getActiveEvent();

        $user->voted_exhibitors = $this->voteService->getUserVotesForActiveOccurrence($userId);
        $user->bookings = $this->bookingService->getUserConfirmedBookings($userId);
        $user->exhibitor_application_status = $event
            ? $this->applicationService->getApplicationStatus($userId, $event->id)
            : null;

        $user->exhibitor_events = $user->load(['exhibitorProfiles.eventOccurrence'])->exhibitorProfiles;

        return $user;
    }

}
