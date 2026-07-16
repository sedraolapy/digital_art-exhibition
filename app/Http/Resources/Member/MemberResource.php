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
            'image_url' => $this->image_url ? asset('storage/'.$this->image_url) : null,
            'social_links' => $this->socialLinks->map(function ($link) {
                return [
                    'platform' => $link->platform,
                    'url'      => $link->url,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
