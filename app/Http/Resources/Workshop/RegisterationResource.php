<?php

namespace App\Http\Resources\Workshop;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterationResource extends JsonResource
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
            'workshop_id'  =>$this->workshop_id,
            'status'   => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
