<?php

namespace App\Http\Controllers\User;

use App\Enums\EventOccurrenceStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserProfileRequest;
use App\Http\Resources\User\UserProfileResource;
use App\Http\Resources\UserResource;
use App\Models\EventOccurrence;
use App\Models\Vote;
use App\Services\User\UserProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    private UserProfileService $profileService;

    public function __construct(UserProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show()
    {
        $profile = Auth::user()->profile()->with('bookings.lecture')->first();

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
            'message' => 'تم عرض ملف المستخدم بنجاح',
            'data'    => new UserProfileResource($profile),
        ]);
    }



    public function update(UpdateUserProfileRequest $request)
    {
        $data = $request->validated();
        $user = $this->profileService->update($request->user(), $data);

        return response()->json([
            'message' => 'تم تحديث ملف المستخدم بنجاح',
            'data'    => new UserProfileResource($user->profile),
        ]);
    }
}
