<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Resources\Member\MemberResource;
use App\Services\Member\MemberService;

class MemberController extends Controller
{
    public function __construct(private MemberService $memberService) {}

    public function index()
    {
        $members = $this->memberService->getAll();

        return response()->json([
            'message' => 'تم جلب بيانات الأعضاء بنجاح',
            'data' => MemberResource::collection($members),
        ]);
    }
}