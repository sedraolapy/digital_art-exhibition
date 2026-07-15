<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'profile_image_url' => $this->profile_image_url
                ? asset('storage/' . $this->profile_image_url)
                : null,
            'user' => new UserResource($this->user),
        ];
    }
}
