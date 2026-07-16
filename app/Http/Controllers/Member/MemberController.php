<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Resources\Member\MemberResource;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with('socialLinks')->get();

        return response()->json([
            'data' => MemberResource::collection($members),
            'message' => 'Members retrieved successfully',
        ]);
    }
}
