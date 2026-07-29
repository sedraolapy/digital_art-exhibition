<?php

namespace App\Http\Controllers\CheckIn;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\CheckInRequest;
use App\Http\Resources\User\UserResource;
use App\Services\Event\CheckInService;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    private CheckInService $checkInService;

    public function __construct(CheckInService $checkInService)
    {
        $this->checkInService = $checkInService;
    }

    public function store(CheckInRequest $request)
    {
        $session = $request->checkInSession;
        $data = $request->validated();
        $result = $this->checkInService->checkIn($data, $session);


        return response()->json([
            'message' => $result['message'],
            'data' =>
                $result['data']
                    ? new UserResource($result['data'])
                    : null,
        ]);
    }
}
