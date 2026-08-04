<?php

namespace App\Services\Lecture;

use App\Enums\EventOccurrenceStatus;
use App\Models\Lecture;

class LectureService
{
    public function getActiveLectures()
    {
        return Lecture::whereHas('day.occurrence', function ($query) {
            $query->where('status', EventOccurrenceStatus::ACTIVE->value);
        })->get();
    }

}
