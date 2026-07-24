<?php

namespace App\Services\Sponsor;

use App\Enums\EventOccurrenceStatus;
use App\Models\EventOccurrence;
use App\Models\Sponsor;

class SponsorService
{
    public function getSponsorsForActiveOccurrence()
    {
        $activeOccurrence = EventOccurrence::where('status', EventOccurrenceStatus::ACTIVE->value)
            ->with('cycle')
            ->firstOrFail();

        $occurrenceSponsors = Sponsor::whereHas('occurrences', function ($query) use ($activeOccurrence) {
                $query->where('event_occurrence_id', $activeOccurrence->id);
            })
            ->with(['cycles', 'occurrences.location', 'occurrences.cycle'])
            ->get();

        $cycleSponsors = Sponsor::whereHas('cycles', function ($query) use ($activeOccurrence) {
                $query->where('cycle_id', $activeOccurrence->cycle_id);
            })
            ->with(['cycles', 'occurrences.location', 'occurrences.cycle'])
            ->get();

        return $occurrenceSponsors->merge($cycleSponsors);
    }
}
