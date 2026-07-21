<?php

namespace App\Http\Controllers\Statistic;

use App\Http\Controllers\Controller;
use App\Http\Resources\Statistic\StatisticResource;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        $satistics = Statistic::get();

        return response()->json([
            'message' => 'تم جلب الاحصائيات بنجاح',
            'data' => StatisticResource::collection($satistics),
        ]);
    }
}
