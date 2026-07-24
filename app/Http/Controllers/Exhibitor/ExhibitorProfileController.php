<?php

namespace App\Http\Controllers\Exhibitor;

use App\Enums\EventOccurrenceStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exhibitor\UpdateExhibitorProfileRequest;
use App\Http\Resources\Exhibitor\ExhibitorProfileResource;
use App\Models\EventOccurrence;
use App\Models\Vote;
use App\Services\Booking\BookingService;
use App\Services\Exhibitor\ExhibitorProfileService;
use App\Services\Exhibitor\VoteService;
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
        $user = Auth::user();
        $profile = $this->profileService->getExhibitorProfileData($user);

        return response()->json([
            'message' => 'تم عرض ملف العارض بنجاح',
            'data'    => new ExhibitorProfileResource($profile),
        ]);
    }

    public function update(UpdateExhibitorProfileRequest $request)
    {
        $data = $request->validated();
        $exprofile = Auth::user()->exhibitorProfile;

        $profile = $this->profileService->update($exprofile, $data);

        return response()->json([
            'message' => 'تم تحديث ملف العارض بنجاح',
            'data'    => new ExhibitorProfileResource($profile),
        ]);
    }

}
