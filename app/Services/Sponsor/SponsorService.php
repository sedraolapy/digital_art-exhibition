<?php

namespace App\Services\Sponsor;

use App\Enums\CycleStatus;
use App\Models\Cycle;
use App\Models\Sponsor;
use App\Services\Event\EventService;

class SponsorService
{
    public function __construct(private EventService $eventService) {}

    public function getSponsorsForActiveOccurrence()
    {
        $activeCycle = Cycle::where(
            'status',
            CycleStatus::ACTIVE->value
        )->first();

        if (! $activeCycle) {
            throw new \Exception(
                'لا توجد دورة فعّالة حالياً لعرض الرعاة.'
            );
        }

        $activeOccurrence = $this->eventService->getActiveEvent();

        return Sponsor::where(function ($query) use ($activeCycle, $activeOccurrence) {

            $query->whereHas('cycles', function ($query) use ($activeCycle) {
                $query->where('cycle_id', $activeCycle->id);
            });

            if ($activeOccurrence) {
                $query->orWhereHas('occurrences', function ($query) use ($activeOccurrence) {
                    $query->where('event_occurrence_id', $activeOccurrence->id);
                });
            }

        })
        ->with([
            'cycles',
            'occurrences.location',
            'occurrences.cycle',
            'media',
        ])
        ->get();
    }
}