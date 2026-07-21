<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lecture\StoreBookingRequest;
use App\Http\Resources\Booking\BookingResource;
use App\Services\Booking\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function store(StoreBookingRequest $request)
    {
        $userId = $request->user()->id;
        $lectureId = $request->lecture_id;

        $booking = $this->bookingService->createBooking($userId, $lectureId);

        return response()->json([
            'message' => 'تم الحجز بنجاح',
            'data'    => new BookingResource($booking),
        ]);

    }

    public function destroy($id)
    {
        $this->bookingService->cancelBooking($id);

        return response()->json([
            'message' => 'تم إلغاء الحجز بنجاح',
            'data' => null,
        ]);
    }
}
