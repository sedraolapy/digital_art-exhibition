<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lecture\StoreBookingRequest;
use App\Http\Resources\Booking\BookingResource;
use App\Services\Booking\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(private BookingService $bookingService){}

    public function store(StoreBookingRequest $request)
    {
        $data = $request->validated();

        $booking = $this->bookingService->createBooking($request->user()->id,$data['lecture_id']);

        return response()->json([
            'message' => 'تم الحجز بنجاح',
            'data' => new BookingResource($booking),
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
