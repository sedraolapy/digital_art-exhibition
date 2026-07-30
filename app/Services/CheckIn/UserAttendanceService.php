<?php

namespace App\Services\CheckIn;

use App\Enums\EventOccurrenceStatus;
use App\Models\EventOccurrence;
use App\Models\User;

class UserAttendanceService
{
    public function hasCheckedIn(User $user): bool
    {
        $event = EventOccurrence::where('status', EventOccurrenceStatus::ACTIVE)->first();
        if (! $event) {
            return false;
        }

        return $user->eventAttendances()
            ->whereHas('eventDay', function ($query) use ($event) {
                $query->where('event_occurrence_id', $event->id);
            })
            ->exists();
    }
}