<?php

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LectureAttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->lecture->id,
            'title' => $this->lecture->title,
            'speaker' => $this->lecture->speaker_name,
            'date' => $this->lecture->date,
            'checked_in_at' => $this->created_at,
        ];
    }
}
