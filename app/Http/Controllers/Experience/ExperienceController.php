<?php

namespace App\Http\Controllers\Experience;

use App\Enums\ExperienceStatus;
use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;
use App\Http\Resources\Experience\ExperienceResource;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::where('status', ExperienceStatus::PUBLISHED->value)
            ->with('media')
            ->get();

        return ExperienceResource::collection($experiences);
    }
}
