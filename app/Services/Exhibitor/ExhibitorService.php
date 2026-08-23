<?php

namespace App\Services\Exhibitor;

use App\Models\ExhibitorProfile;
use App\Models\Vote;
use App\Services\Event\EventService;
use Illuminate\Support\Facades\Auth;

class ExhibitorService
{
    public function __construct(
        private EventService $eventService
    ) {}

    public function getExhibitors(): array
    {
        $activeEvent = $this->eventService->getActiveEvent();

        if (! $activeEvent) {
            return [
                'voting_status' => false,
                'exhibitors' => collect(),
            ];
        }

        $userId = Auth::id();

        $votedExhibitors = Vote::where('user_id', $userId)
            ->where('event_occurrence_id', $activeEvent->id)
            ->pluck('exhibitor_id')
            ->toArray();
        $exhibitors = ExhibitorProfile::with([
            'user',
            'socialLinks',
            'media',
            'category'
            ])
            ->where('event_occurrence_id', $activeEvent->id)
            ->get()
            ->map(function ($exhibitor) use ($votedExhibitors) {
                $exhibitor->can_vote = ! in_array(
                    $exhibitor->id,
                    $votedExhibitors
                );

                return $exhibitor;
            });

        return [
            'voting_status' => $activeEvent->is_voting_enabled,
            'exhibitors' => $exhibitors,
        ];
    }
}