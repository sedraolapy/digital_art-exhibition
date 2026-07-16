<?php

namespace App\Http\Controllers\Sponsor;

use App\Enums\EventOccurrenceStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Sponsor\SponsorResource;
use App\Models\EventOccurrence;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    public function activeSponsors()
    {
       // جلب الـ Occurrence الوحيدة الـ Active
    $activeOccurrence = EventOccurrence::where('status', EventOccurrenceStatus::ACTIVE->value)
    ->with('cycle')
    ->firstOrFail();

    // جلب الرعاة المرتبطين بالـ Occurrence الـ Active
    $occurrenceSponsors = Sponsor::whereHas('occurrences', function ($query) use ($activeOccurrence) {
            $query->where('event_occurrence_id', $activeOccurrence->id);
        })
        ->with(['cycles', 'occurrences.location', 'occurrences.cycle'])
        ->get();

    // جلب الرعاة المرتبطين بالـ Cycle تبع الـ Occurrence الـ Active
    $cycleSponsors = Sponsor::whereHas('cycles', function ($query) use ($activeOccurrence) {
            $query->where('cycle_id', $activeOccurrence->cycle_id);
        })
        ->with(['cycles', 'occurrences.location', 'occurrences.cycle'])
        ->get();

        $allSponsors = $occurrenceSponsors->merge($cycleSponsors);

        return response()->json([
            'sponsors' => SponsorResource::collection($allSponsors),
        ]);
    }
}
