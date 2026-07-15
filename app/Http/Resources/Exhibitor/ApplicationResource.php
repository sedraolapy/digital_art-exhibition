<?php

namespace App\Http\Resources\Exhibitor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'user'             => [
                'id'    => $this->user->id,
                'name'  => $this->user->first_name . ' ' . $this->user->last_name,
                'email' => $this->user->email,
            ],
            'event_occurrence' => [
                'id' => $this->eventOccurrence->id,
            ],
            'category'         => [
                'id'   => $this->category->id,
                'name' => $this->category->name,
            ],
            'experience_years' => $this->experience_years,
            'cv_file'          => $this->cv_file ? asset('storage/'.$this->cv_file) : null,
            'portfolio_url'    => $this->portfolio_url,
            'bio'              => $this->bio,
            'image_url'        => $this->image_url ? asset('storage/'.$this->image_url) : null,
            'status'           => $this->status,
            'created_at'       => $this->created_at->toDateTimeString(),

            'social_links'     => $this->socialLinks->map(fn ($link) => [
                'platform' => $link->platform,
                'url'      => $link->url,
            ]),
        ];
    }
}
