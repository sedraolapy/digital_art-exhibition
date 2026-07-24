<?php

namespace App\Http\Controllers\Sponsor;

use App\Enums\EventOccurrenceStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Sponsor\SponsorResource;
use App\Models\Category;
use App\Models\EventOccurrence;
use App\Models\Sponsor;
use App\Services\Sponsor\SponsorService;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    private SponsorService $sponsorService;

    public function __construct(SponsorService $sponsorService)
    {
        $this->sponsorService = $sponsorService;
    }

    public function index()
    {
        $sponsors = $this->sponsorService->getSponsorsForActiveOccurrence();

        return response()->json([
            'message' => 'تم جلب بيانات الرعاة بنجاح',
            'data'    => SponsorResource::collection($sponsors),
        ]);
    }

    public function getCategoris()
    {
        $categories= Category::where('is_active', true)->get();

        return response()->json([
            'message' => 'تم جلب التصنيفات بنجاح',
            'data'    => $categories,
        ]);
    }
}
