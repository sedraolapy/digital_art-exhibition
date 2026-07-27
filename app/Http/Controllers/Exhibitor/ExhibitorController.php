<?php

namespace App\Http\Controllers\Exhibitor;

use App\Enums\EventOccurrenceStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Exhibitor\ExhibitorProfileResource;
use App\Models\EventOccurrence;
use App\Models\ExhibitorProfile;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExhibitorController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $activeOccurrence = EventOccurrence::where('status', EventOccurrenceStatus::ACTIVE->value)->first();

        $exhibitors = ExhibitorProfile::with('user.socialLinks')
            ->whereHas('eventOccurrence', function ($query) {
                $query->where('status', EventOccurrenceStatus::ACTIVE->value);
            })
            ->get()
            ->map(function ($exhibitor) use ($userId, $activeOccurrence) {
                $hasVoted = Vote::where('user_id', $userId)
                    ->where('exhibitor_id', $exhibitor->id)
                    ->where('event_occurrence_id', $activeOccurrence->id)
                    ->exists();

                $exhibitor->can_vote = !$hasVoted;
                return $exhibitor;
            });

        return response()->json([
            'voting_status' => $activeOccurrence?->is_voting_enabled,
            'message'       => 'تم جلب بيانات العارضين بنجاح',
            'data'          => ExhibitorProfileResource::collection($exhibitors),
        ]);
    }

}
