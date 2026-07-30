<?php

namespace App\Services\Event;

use App\Enums\EventOccurrenceStatus;
use App\Models\EventDay;
use App\Models\EventOccurrence;

class EventService
{
    public function getActiveEventDays()
    {
        $event = $this->getActiveEvent();
        return $event ? EventDay::where('event_occurrence_id', $event->id)->get() : null;
    }

    public function getActiveEvent(): ?EventOccurrence
    {
        return EventOccurrence::where('status', EventOccurrenceStatus::ACTIVE->value)->first();
    }
}
