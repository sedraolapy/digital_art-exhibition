<?php

namespace App\Http\Controllers\CheckIn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckInSessionController extends Controller
{
    public function show(Request $request, CheckInSessionService $service)
    {
        return response()->json(
            $service->validateSession($request)
        );
    }
}
