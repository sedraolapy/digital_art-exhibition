<?php

namespace App\Services\Lecture;

use App\Enums\BookingStatus;
use App\Enums\EventOccurrenceStatus;
use App\Models\Lecture;

class LectureService
{
    public function getActiveLectures()
    {
        return Lecture::with(['day', 'media'])
            ->withCount([
                'bookings' => fn ($query) =>
                    $query->where(
                        'status',
                        BookingStatus::CONFIRMED->value
                    ),
            ])
            ->whereHas('day.occurrence', fn($q) => $q->where('status', EventOccurrenceStatus::ACTIVE->value))
            ->get();
    }

}
