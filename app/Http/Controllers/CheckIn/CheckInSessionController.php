<?php

namespace App\Http\Controllers\CheckIn;

use App\Http\Controllers\Controller;
use App\Services\CheckIn\CheckInSessionService;
use Illuminate\Http\Request;

class CheckInSessionController extends Controller
{

    public function __construct(private CheckInSessionService $sessionService){}

    public function show(Request $request) {

        $data = $this->sessionService->validateSession($request);

        return response()->json([
            'message' => $data['message'],
            'data' => $data['data'],
        ]);

    }
}