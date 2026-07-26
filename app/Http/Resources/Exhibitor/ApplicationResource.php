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
            'category'         => [
                'name' => $this->category->name,
            ],
            'experience_years' => $this->experience_years,
            'cv_file'          => $this->getMedia('application_cv')->map(fn($media) => $media->getFullUrl()),
            'portfolio_url'    => $this->portfolio_url,
            'bio'              => $this->bio,
            'image'            => $this->getMedia('application_image')->map(fn($media) => $media->getFullUrl('webp')),
            'status'           => $this->status,
            'created_at'       => $this->created_at->toDateTimeString(),

        ];
    }
}
