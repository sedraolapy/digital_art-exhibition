<?php

namespace App\Services\Exhibitor;

use App\Enums\EventOccurrenceStatus;
use App\Models\EventOccurrence;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoteService
{
    public function vote(int $exhibitorId): array
    {
        $userId = Auth::id();

        $activeOccurrence = EventOccurrence::where('status', EventOccurrenceStatus::ACTIVE->value)->first();

        if (! $activeOccurrence) {
            return [
                'message' => 'لا يوجد حدث فعّال حالياً',
                'data'    => null,
            ];
        }

        if (!$activeOccurrence->is_voting_enabled) {
            return [
                'message' => 'التصويت غير مفعل حالياً ',
                'data'    => null,
            ];
        }

        $alreadyVoted = Vote::where('user_id', $userId)
            ->where('exhibitor_id', $exhibitorId)
            ->where('event_occurrence_id', $activeOccurrence->id)
            ->exists();

        if ($alreadyVoted) {
            return [
                'message' => 'لقد قمت بالتصويت لهذا العارض مسبقًا',
                'data'    => null,
            ];
        }

        $vote = Vote::create([
            'user_id'            => $userId,
            'exhibitor_id'       => $exhibitorId,
            'event_occurrence_id'=> $activeOccurrence->id,
        ]);

        return [
            'message' => 'تم التصويت بنجاح',
            'data'    => $vote,
        ];
    }

    public function getUserVotesForActiveOccurrence(int $userId): array
    {
        $activeOccurrence = EventOccurrence::where('status', EventOccurrenceStatus::ACTIVE->value)->first();

        if (! $activeOccurrence) {
            return [];
        }

        return Vote::where('user_id', $userId)
            ->where('event_occurrence_id', $activeOccurrence->id)
            ->pluck('exhibitor_id')
            ->toArray();
    }
}
