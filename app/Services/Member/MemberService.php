<?php

namespace App\Services\Member;

use App\Models\Member;
use Illuminate\Database\Eloquent\Collection;

class MemberService
{
    public function getAll(): Collection
    {
        return Member::with('socialLinks')
            ->orderBy('name')
            ->get();
    }
}