<?php

namespace App\Http\Controllers\Exhibitor;

use App\Http\Controllers\Controller;
use App\Http\Resources\Exhibitor\ExhibitorProfileResource;
use App\Services\Exhibitor\ExhibitorService;

class ExhibitorController extends Controller
{
    public function __construct(private ExhibitorService $exhibitorService) {}

    public function index()
    {
        $result = $this->exhibitorService->getExhibitors();

        return response()->json([
            'voting_status' => $result['voting_status'],
            'message'       => 'تم جلب بيانات العارضين بنجاح',
            'data'          => ExhibitorProfileResource::collection($result['exhibitors']),
        ]);
    }
}
