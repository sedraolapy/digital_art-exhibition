<?php

namespace App\Observers;

use App\Enums\EventOccurrenceStatus;
use App\Enums\ExperienceStatus;
use App\Models\EventOccurrence;
use App\Models\Experience;
use Illuminate\Validation\ValidationException;

class EventOccurrenceObserver
{
    /**
     * Handle the EventOccurrence "created" event.
     */
    public function created(EventOccurrence $eventOccurrence): void
    {
        //
    }

    /**
     * Handle the EventOccurrence "updated" event.
     */
    public function updated(EventOccurrence $eventOccurrence): void
    {
        if (
            $eventOccurrence->wasChanged('status') &&
            $eventOccurrence->status === EventOccurrenceStatus::FINISHED
        ) {
            Experience::create([
                'title'       => $eventOccurrence->title,
                'description' => null,
                'start_date'  => $eventOccurrence->start_date,
                'end_date'    => $eventOccurrence->end_date,
                'status'      => ExperienceStatus::DRAFT->value,
            ]);
        }
    }

    public function updating(EventOccurrence $eventOccurrence): void
    {
        if (
            $eventOccurrence->isDirty('status') &&
            $eventOccurrence->status === EventOccurrenceStatus::ACTIVE
        ) {
            $exists = EventOccurrence::query()
                ->where('status', EventOccurrenceStatus::ACTIVE)
                ->whereKeyNot($eventOccurrence->id)
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'status' => 'There is already an active event.',
                ]);
            }
        }
    }
    /**
     * Handle the EventOccurrence "deleted" event.
     */
    public function deleted(EventOccurrence $eventOccurrence): void
    {
        //
    }

    /**
     * Handle the EventOccurrence "restored" event.
     */
    public function restored(EventOccurrence $eventOccurrence): void
    {
        //
    }

    /**
     * Handle the EventOccurrence "force deleted" event.
     */
    public function forceDeleted(EventOccurrence $eventOccurrence): void
    {
        //
    }
}
