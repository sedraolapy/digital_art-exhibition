<?php

namespace App\Http\Resources\Workshop;

use App\Enums\BookingStatus;
use App\Models\WorkshopRegistration;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkshopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $registerationsCount = WorkshopRegistration::where('workshop_id', $this->id)->where('status', BookingStatus::CONFIRMED->value)->count();
        $remainingSeats = $this->max_seats - $registerationsCount;

        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'image'       => $this->getMedia('workshops')->map(fn($media) => $media->getFullUrl('webp')),
            'gallery'     => $this->getMedia('workshop_gallery')->map(fn($media) => $media->getFullUrl('webp')),
            'description' => $this->description,
            'speaker'     => $this->speaker_name,
            'max_seats'   => $this->max_seats,
            'remainingSeats'=> $remainingSeats,
            'date'        => $this->date,
            'start_time'  => $this->start_time,
            'end_time'    => $this->end_time,
            'status'    => $this->status,
        ];
    }
}
