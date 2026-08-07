<?php

namespace App\Services\Lecture;

use App\Enums\EventOccurrenceStatus;
use App\Models\Lecture;

class LectureService
{
    public function getActiveLectures()
    {
        return Lecture::with(['day', 'media'])
            ->withCount('bookings')
            ->whereHas('day.occurrence', fn($q) => $q->where('status', EventOccurrenceStatus::ACTIVE->value))
            ->get();
    }

}
