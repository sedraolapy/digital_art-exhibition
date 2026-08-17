<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lecture\StoreBookingRequest;
use App\Http\Resources\Booking\BookingResource;
use App\Services\Lecture\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function destroy(int $id)
    {
        $userId = Auth::id();
        $this->bookingService->cancelBooking($id, $userId);

        return response()->json([
            'message' => 'تم إلغاء الحجز بنجاح',
            'data' => null,
        ]);
    }
}
