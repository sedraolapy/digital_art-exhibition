<?php

namespace App\Http\Controllers\CheckIn;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\CheckInRequest;
use App\Http\Resources\User\CheckInResource;
use App\Http\Resources\User\UserResource;
use App\Services\CheckIn\CheckInService;

class CheckInController extends Controller
{
    public function __construct(private CheckInService $checkInService) {}

    public function store(CheckInRequest $request)
    {
        $session = $request->attributes->get('checkInSession');
        $data =$request->validated();

        $result = $this->checkInService->checkIn($data,$session);

        return response()->json([
            'message' => $result['message'],
            'data' => $result['data']? new CheckInResource($result['data']): null,
        ]);
    }
}