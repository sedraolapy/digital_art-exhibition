<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Workshop\StoreRegistrationRequest;
use App\Http\Resources\Workshop\RegisterationResource;
use App\Services\Workshop\WorkshopRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkshopRegistrationController extends Controller
{
    public function __construct(private WorkshopRegistrationService $registrationService){}

    public function store(StoreRegistrationRequest $request)
    {
        $data = $request->validated();

        $registration = $this->registrationService->createRegistration($request->user()->id,$data['workshop_id']);

        return response()->json([
            'message' => 'تم الحجز بنجاح',
            'data' => new RegisterationResource($registration),
        ]);
    }

    public function destroy(int $id)
    {
        $this->registrationService->cancelRegistration($id,Auth::id());

        return response()->json([
            'message' => 'تم إلغاء الحجز بنجاح',
            'data' => null,
        ]);
    }
}
