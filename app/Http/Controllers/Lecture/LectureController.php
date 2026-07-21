<?php

namespace App\Http\Controllers\Lecture;

use App\Enums\EventOccurrenceStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Lecture\LectureResource;
use App\Models\Booking;
use App\Models\Lecture;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    public function index()
    {
        $lectures = Lecture::whereHas('day.occurrence', function ($query) {
            $query->where('status', EventOccurrenceStatus::ACTIVE->value);
        })->get();


        return response()->json([
            'message' => 'تم جلب االمحاضرات بنجاح',
            'data' => LectureResource::collection($lectures),
        ]);
    }
}
