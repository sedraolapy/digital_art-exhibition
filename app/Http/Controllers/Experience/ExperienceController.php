<?php

namespace App\Http\Controllers\Experience;

use App\Http\Controllers\Controller;
use App\Http\Resources\Experience\ExperienceResource;
use App\Services\Experience\ExperienceService;

class ExperienceController extends Controller
{
    public function __construct(private ExperienceService $experienceService) {}

    public function index()
    {
        $experiences = $this->experienceService->getPublished();

        return response()->json([
            'message' => 'تم جلب التجارب المنشورة بنجاح',
            'data' => ExperienceResource::collection($experiences),
        ]);
    }
}