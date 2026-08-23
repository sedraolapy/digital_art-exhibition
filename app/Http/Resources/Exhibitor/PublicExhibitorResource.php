<?php

namespace App\Http\Resources\Exhibitor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicExhibitorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'exhibitor_id'     => $this->id,
            'first_name'       => $this->user?->first_name,
            'last_name'        => $this->user?->last_name,
            'category'         => $this->category?->name,
            'bio'              => $this->bio,
            'experience_years' => $this->experience_years,
            'portfolio_url'    => $this->portfolio_url,

            'image' => $this->getMedia('exhibitor_image')
                ->map(fn ($media) => $media->getFullUrl('webp')),

            'social_links' => $this->socialLinks?->map(function ($link) {
                return [
                    'platform' => $link->platform,
                    'url'      => $link->url,
                ];
            }) ?? [],
        ];
    }
}