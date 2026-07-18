<?php

namespace App\Http\Controllers\Exhibitor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Exhibitor\StoreExhibitorApplicationRequest;
use App\Http\Resources\Exhibitor\ApplicationResource;
use App\Services\Exhibitor\ExhibitorApplicationService;
use Illuminate\Http\Request;

class ExhibitorApplicationController extends Controller
{
    private ExhibitorApplicationService $service;

    public function __construct(ExhibitorApplicationService $service)
    {
        $this->service = $service;
    }

    public function store(StoreExhibitorApplicationRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();
        $application = $this->service->create($user, $data);

        $application->load([
            'user',
            'eventOccurrence',
            'category',
        ]);

        return response()->json([
            'message' => 'تم تقديم طلبك كعارض بنجاح. يرجى متابعة بريدك الإلكتروني لتلقي ردنا قريباً',
            'data' => new ApplicationResource($application),
        ]);
    }
}
