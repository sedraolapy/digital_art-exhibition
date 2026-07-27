<?php

namespace App\Http\Resources\Exhibitor;

use App\Http\Resources\Booking\BookingResource;
use App\Http\Resources\Lecture\LectureResource;
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
            'user'             => new UserResource($this->user),
            'category'         => $this->category?->name,
            'bio'              => $this->bio,
            'experience_years' => $this->experience_years,
            'cv_file'          =>$this->getMedia('exhibitor_cv')->map(fn($media) => $media->getFullUrl()),
            'portfolio_url'    => $this->portfolio_url,
        ];
    }
}
