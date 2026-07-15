<?php

namespace App\Http\Controllers\Exhibitor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Exhibitor\UpdateExhibitorProfileRequest;
use App\Http\Resources\Exhibitor\ExhibitorProfileResource;
use App\Services\Exhibitor\ExhibitorProfileService;
use Illuminate\Http\Request;

class ExhibitorProfileController extends Controller
{
    private ExhibitorProfileService $profileService;

    public function __construct(ExhibitorProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show()
    {
        $profile = auth()->user()->exhibitorProfile()->first();
        return new ExhibitorProfileResource($profile);
    }

    public function update(UpdateExhibitorProfileRequest $request)
    {
        $data = $request->validated();
        $profile = $this->profileService->update(auth()->user()->exhibitorProfile, $data);

        return (new ExhibitorProfileResource($profile))
            ->additional(['message' => 'Exhibitor profile updated successfully']);
    }

}
