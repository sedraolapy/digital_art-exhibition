<?php

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkshopAttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->workshop->id,
            'title' => $this->workshop->title,
            'speaker' => $this->workshop->speaker_name,
            'date' => $this->workshop->date,
            'checked_in_at' => $this->created_at,
        ];
    }
}
