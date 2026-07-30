<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Str;


class UserQrService
{

    public function generate(User $user): void
    {
        $user->update([
            'qr_token' => Str::uuid()->toString()
        ]);
    }

}