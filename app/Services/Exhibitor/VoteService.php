<?php

namespace App\Services\Exhibitor;

use App\Models\EventAttendance;
use App\Models\ExhibitorProfile;
use App\Models\Vote;
use App\Services\Event\EventService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VoteService
{
    public function __construct(private EventService $eventService) {}

    public function vote(int $exhibitorId): array
    {
        $userId = Auth::id();

        $activeOccurrence = $this->eventService->getActiveEvent();

        if (! $activeOccurrence) {
            return [
                'message' => 'لا يوجد حدث فعّال حالياً',
                'data'    => null,
            ];
        }

        if (! $activeOccurrence->is_voting_enabled) {
            return [
                'message' => 'التصويت غير مفعل حالياً ',
                'data'    => null,
            ];
        }

        $hasAttendance = EventAttendance::where('user_id', $userId)
            ->whereHas('eventDay', function ($query) use ($activeOccurrence) {
                $query->where('event_occurrence_id', $activeOccurrence->id);
            })->exists();

        if (! $hasAttendance) {
            return [
                'message' => 'يجب حضور يوم واحد على الأقل من الحدث قبل التصويت',
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

        $exhibitorBelongsToOccurrence = ExhibitorProfile::where('id', $exhibitorId)
            ->where('event_occurrence_id', $activeOccurrence->id)
            ->exists();

        if (! $exhibitorBelongsToOccurrence) {

            Log::channel('security')->warning('Vote attempt for exhibitor outside active occurrence', [
                'user_id' => $userId,
                'exhibitor_id' => $exhibitorId,
                'occurrence_id' => $activeOccurrence->id,
            ]);
            return [
                'message' => 'هذا العارض لا يتبع للحدث الحالي',
                'data' => null
        ];
        }

        $vote = Vote::create([
            'user_id'             => $userId,
            'exhibitor_id'        => $exhibitorId,
            'event_occurrence_id' => $activeOccurrence->id,
        ]);

        Log::channel('audit')->info('Vote cast', [
            'user_id' => $userId,
            'exhibitor_id' => $exhibitorId,
            'occurrence_id' => $activeOccurrence->id,
        ]);

        return [
            'message' => 'تم التصويت بنجاح',
            'data'    => $vote,
        ];
    }

    public function getUserVotesForActiveOccurrence(int $userId): array
    {
        $activeOccurrence = $this->eventService->getActiveEvent();

        if (! $activeOccurrence) {
            return [];
        }

        return Vote::where('user_id', $userId)
            ->where('event_occurrence_id', $activeOccurrence->id)
            ->pluck('exhibitor_id')
            ->toArray();
    }
}
