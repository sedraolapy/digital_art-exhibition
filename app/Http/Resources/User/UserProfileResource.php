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
            'user'   => new UserResource($this->user),
            'image' => $this->getMedia('user_image')->map(fn ($media) => $media->getFullUrl()),
            'social_links' =>  $this->socialLinks->map(function ($link) {
                    return [
                        'platform' => $link->platform,
                        'url' => $link->url,
                    ];
                })
        ];
    }
}
