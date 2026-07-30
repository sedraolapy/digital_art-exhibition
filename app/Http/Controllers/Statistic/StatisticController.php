<?php

namespace App\Http\Controllers\Statistic;

use App\Http\Controllers\Controller;
use App\Http\Resources\Statistic\StatisticResource;
use App\Services\Statistic\StatisticService;

class StatisticController extends Controller
{
    public function __construct(private StatisticService $statisticService) {}

    public function index()
    {
        $statistics = $this->statisticService->getAll();

        return response()->json([
            'message' => 'تم جلب الاحصائيات بنجاح',
            'data' => StatisticResource::collection($statistics),
        ]);
    }
}