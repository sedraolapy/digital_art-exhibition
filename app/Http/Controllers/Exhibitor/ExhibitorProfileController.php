<?php

namespace App\Http\Controllers\Exhibitor;

use App\Enums\EventOccurrenceStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exhibitor\UpdateExhibitorProfileRequest;
use App\Http\Resources\Exhibitor\ExhibitorProfileResource;
use App\Models\EventOccurrence;
use App\Models\Vote;
use App\Services\Exhibitor\ExhibitorProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ExhibitorProfileController extends Controller
{
    private ExhibitorProfileService $profileService;

    public function __construct(ExhibitorProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show()
    {
        $profile = Auth::user()->exhibitorProfile()->with('bookings.lecture')->first();

        $activeOccurrence = EventOccurrence::where('status', EventOccurrenceStatus::ACTIVE->value)->first();

        $votedExhibitors = [];
        if ($activeOccurrence) {
            $votedExhibitors = Vote::where('user_id', Auth::id())
                ->where('event_occurrence_id', $activeOccurrence->id)
                ->pluck('exhibitor_id')
                ->toArray();
        }

        $profile->voted_exhibitors = $votedExhibitors;

        return response()->json([
            'message' => 'تم عرض ملف العارض بنجاح',
            'data' => new ExhibitorProfileResource($profile),
        ]);
    }

    public function update(UpdateExhibitorProfileRequest $request)
    {
        $data = $request->validated();
        $profile = $this->profileService->update(Auth::user()->exhibitorProfile, $data);

        return response()->json([
            'message' => 'تم تحديث ملف العارض بنجاح',
            'data' => new ExhibitorProfileResource($profile),
        ]);
    }

}
