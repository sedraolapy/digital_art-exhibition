<?php

namespace App\Http\Controllers\Workshop;

use App\Http\Controllers\Controller;
use App\Http\Resources\Workshop\WorkshopResource;
use App\Services\Workshop\WorkshopService;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    public function __construct(private WorkshopService $workshopService){}

    public function index()
    {
        $workshops = $this->workshopService->getWorkshops();

        return response()->json([
            'message' => 'تم جلب الورشات بنجاح',
            'data' => WorkshopResource::collection($workshops),
        ]);
    }
}
