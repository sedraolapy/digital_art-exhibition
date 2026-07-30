<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\ExhibitorApplication;
use App\Services\Booking\BookingService;
use App\Services\CheckIn\UserAttendanceService;
use App\Services\Event\EventService;
use App\Services\Exhibitor\VoteService;


class UserDataService
{
    public function __construct(
        private VoteService $voteService,
        private BookingService $bookingService,
        private UserAttendanceService $attendanceService,
        private EventService $eventService
    ) {}



    public function loadAuthData(User $user): User
    {
        $user->voted_exhibitors = $this->voteService->getUserVotesForActiveOccurrence($user->id);

        $user->bookings = $this->bookingService->getUserConfirmedBookings($user->id);

        $event = $this->eventService->getActiveEvent();
        $user->exhibitor_application_status =
            ExhibitorApplication::where(
                'user_id',
                $user->id
            )->where('event_occurrence_id',$event->id)
            ->value('status');

        $user->is_checked_in = $this->attendanceService->hasCheckedIn($user);

        return $user;
    }

}