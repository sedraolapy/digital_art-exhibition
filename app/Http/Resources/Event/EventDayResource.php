<?php

namespace App\Http\Resources\Event;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventDayResource extends JsonResource
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
            'day_number'  =>$this->day_label,
            'event_occurrence_id'  =>$this->event_occurrence_id,
            'date'  =>$this->date,
        ];
    }
}
