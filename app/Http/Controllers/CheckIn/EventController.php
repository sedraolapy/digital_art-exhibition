<?php

namespace App\Http\Controllers\CheckIn;

use App\Enums\EventOccurrenceStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Event\EventDayResource;
use App\Models\EventDay;
use App\Models\EventOccurrence;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $currentEventId = EventOccurrence::where('status', EventOccurrenceStatus::ACTIVE->value)->pluck('id');

        $eventDays = EventDay::where('event_occurrences_id', $currentEventId)->get();

        return response()->json([
            'message' => 'تم جلب الايام بنجاح',
            'data' => EventDayResource::collection($eventDays),
        ]);
    }
}
