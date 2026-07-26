<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Booking\BookingResource;
use App\Http\Resources\Lecture\LectureResource;
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
            'user' => new UserResource($this->user),
            'image'     =>  $this->getMedia('user_profie')->map(fn($media) => $media->getFullUrl('webp')),
        ];
    }
}
