<?php

namespace App\Http\Controllers\Exhibitor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Exhibitor\VoteRequest;
use App\Http\Resources\Exhibitor\VoteResource;
use App\Services\Exhibitor\VoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    protected VoteService $voteService;

    public function __construct(VoteService $voteService)
    {
        $this->voteService = $voteService;
    }

    public function store(VoteRequest $request)
    {
        $exhibitorId = $request->validated()['exhibitor_id'];
        $result = $this->voteService->vote($exhibitorId);

        return response()->json([
            'message' => $result['message'],
            'data'    => $result['data'] ? new VoteResource($result['data']) : null,
        ]);
    }

}
