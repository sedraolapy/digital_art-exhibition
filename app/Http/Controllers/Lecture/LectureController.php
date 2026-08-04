<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Http\Resources\Lecture\LectureResource;
use App\Services\Lecture\LectureService;

class LectureController extends Controller
{
    public function __construct(private LectureService $lectureService){}

    public function index()
    {
        $lectures = $this->lectureService->getActiveLectures();

        return response()->json([
            'message' => 'تم جلب المحاضرات بنجاح',
            'data' => LectureResource::collection($lectures),
        ]);
    }
}
