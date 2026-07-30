<?php

namespace App\Services\Event;

use App\Enums\EventOccurrenceStatus;
use App\Models\EventDay;
use App\Models\EventOccurrence;
use Illuminate\Database\Eloquent\Collection;

class EventService
{
    public function getActiveEventDays()
    {
        $event = EventOccurrence::where('status',EventOccurrenceStatus::ACTIVE->value)->first();

        if (! $event) {
            return ;
        }

        return EventDay::where('event_occurrence_id', $event->id)->get();
    }

    public function getActiveEvent(): ?EventOccurrence
    {
        return EventOccurrence::where('status',EventOccurrenceStatus::ACTIVE->value)->first();
    }
}