<?php

namespace App\Http\Resources\Booking;

use App\Http\Resources\Lecture\LectureResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'user_id'  =>$this->user_id,
            'lecture_id'  =>$this->lecture_id,
            'status'   => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
