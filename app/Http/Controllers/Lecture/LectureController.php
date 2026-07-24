<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Http\Resources\Lecture\LectureResource;
use App\Services\Booking\LectureService;

class LectureController extends Controller
{
    private LectureService $lectureService;

    public function __construct(LectureService $lectureService)
    {
        $this->lectureService = $lectureService;
    }

    public function index()
    {
        $lectures = $this->lectureService->getActiveLectures();

        return response()->json([
            'message' => 'تم جلب المحاضرات بنجاح',
            'data' => LectureResource::collection($lectures),
        ]);
    }
}
