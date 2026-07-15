<?php

namespace App\Http\Resources\Exhibitor;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExhibitorProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'user'            => new UserResource($this->user),
            'category'        => $this->category?->name,
            'bio'             => $this->bio,
            'experience_years'=> $this->experience_years,
            'cv_file'          => $this->cv_file? asset('storage/' . $this->cv_file): null,
            'portfolio_url'   => $this->portfolio_url,
            'image_url'       => $this->image_url ? asset('storage/' . $this->image_url) : null,
            'social_links'     => $this->socialLinks->map(function ($link) {
                return [
                    'platform' => $link->platform,
                    'url'      => $link->url,
                ];
            }),
        ];
    }
}
