<?php

namespace App\Http\Resources\Lecture;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LectureResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $bookingsCount = Booking::where('lecture_id', $this->id)->count();
        $remainingSeats = $this->max_seats - $bookingsCount;

        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'image'       => $this->getMedia('lectures')->map(fn($media) => $media->getFullUrl('webp')),
            'description' => $this->description,
            'speaker'     => $this->speaker_name,
            'max_seats'   => $this->max_seats,
            'remainingSeats'=> $remainingSeats,
            'date'        => $this->date,
            'start_time'  => $this->start_time,
            'end_time'    => $this->end_time,
            'hasEnded' => $this->hasEnded,
            'event_day'   => [
                'day_number' => $this->day->day_number,
                'date'       => $this->day->date,
            ],
        ];
    }
}
