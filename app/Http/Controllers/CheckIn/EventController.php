<?php

namespace App\Http\Controllers\CheckIn;

use App\Http\Controllers\Controller;
use App\Http\Resources\Event\EventDayResource;
use App\Services\Event\EventService;

class EventController extends Controller
{
    public function __construct(private EventService $eventService) {}

    public function index()
    {
        $eventDays = $this->eventService->getActiveEventDays();

        return response()->json([
            'message' => 'تم جلب الأيام بنجاح',
            'data' => EventDayResource::collection($eventDays),
        ]);
    }
}