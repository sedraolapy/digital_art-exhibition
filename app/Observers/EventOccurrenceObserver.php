<?php

namespace App\Observers;

use App\Enums\EventOccurrenceStatus;
use App\Models\EventOccurrence;
use App\Services\Event\EventFinishedService;
use Illuminate\Validation\ValidationException;

class EventOccurrenceObserver
{
    public function created(EventOccurrence $eventOccurrence): void
    {
       //
    }

    public function updated(EventOccurrence $eventOccurrence): void
    {
        if ($this->finishedEvent($eventOccurrence)) {
            app(EventFinishedService::class)->handle($eventOccurrence);
        }
    }

    public function updating(EventOccurrence $eventOccurrence): void
    {
        if ($this->activatingEvent($eventOccurrence) && $this->anotherActiveEventExists($eventOccurrence)) {
            throw ValidationException::withMessages([
                'status' => 'There is already an active event.',
            ]);
        }
    }

    public function deleted(EventOccurrence $eventOccurrence): void {}
    public function restored(EventOccurrence $eventOccurrence): void {}
    public function forceDeleted(EventOccurrence $eventOccurrence): void {}

    // 🔹 دوال خاصة لتوضيح المنطق
    private function finishedEvent(EventOccurrence $eventOccurrence): bool
    {
        return $eventOccurrence->wasChanged('status')
            && $eventOccurrence->status === EventOccurrenceStatus::FINISHED;
    }

    private function activatingEvent(EventOccurrence $eventOccurrence): bool
    {
        return $eventOccurrence->isDirty('status')
            && $eventOccurrence->status === EventOccurrenceStatus::ACTIVE;
    }

    private function anotherActiveEventExists(EventOccurrence $eventOccurrence): bool
    {
        return EventOccurrence::query()
            ->where('status', EventOccurrenceStatus::ACTIVE)
            ->whereKeyNot($eventOccurrence->id)
            ->exists();
    }
}
