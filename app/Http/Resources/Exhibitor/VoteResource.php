<?php

namespace App\Http\Resources\Exhibitor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'user_id'            => $this->user_id,
            'exhibitor_id'       => $this->exhibitor_id,
            'event_occurrence_id'=> $this->event_occurrence_id,
        ];
    }
}
