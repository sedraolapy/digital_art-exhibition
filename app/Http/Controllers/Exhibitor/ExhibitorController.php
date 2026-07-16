<?php

namespace App\Http\Controllers\Exhibitor;

use App\Enums\EventOccurrenceStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Exhibitor\ExhibitorProfileResource;
use App\Models\EventOccurrence;
use App\Models\ExhibitorProfile;
use Illuminate\Http\Request;

class ExhibitorController extends Controller
{
    public function index()
    {
        $exhibitors = ExhibitorProfile::with('socialLinks')->get();
        $voting= EventOccurrence::where('status', EventOccurrenceStatus::ACTIVE->value)->pluck('is_voting_enabled');

        return response()->json([
            'voting_status' => $voting,
            'data' => ExhibitorProfileResource::collection($exhibitors),
            'message' => 'exhibitors retrieved successfully',
        ]);
    }
}
