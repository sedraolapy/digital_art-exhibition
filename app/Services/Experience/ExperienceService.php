<?php

namespace App\Services\Experience;

use App\Enums\ExperienceStatus;
use App\Models\Experience;
use Illuminate\Database\Eloquent\Collection;

class ExperienceService
{
    public function getPublished(): Collection
    {
        return Experience::with('media')
            ->where('status', ExperienceStatus::PUBLISHED->value)
            ->get();
    }
}