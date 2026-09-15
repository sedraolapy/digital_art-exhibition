<?php

namespace App\Http\Resources\Member;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'role'      => $this->role,
            'bio'       => $this->bio,
            'portfolio_url'   => $this->portfolio_url,
            'image'     => $this->getMedia('members')->map(fn($media) => $media->getFullUrl()),
            'social_links' => $this->socialLinks->map(function ($link) {
                return [
                    'platform' => $link->platform,
                    'url'      => $link->url,
                ];
            }),
        ];
    }
}
