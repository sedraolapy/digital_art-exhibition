<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckInSession extends Model
{
    protected $fillable = [
        'user_id',
        'token_hash',
        'device_id',
        'expires_at',
        'is_active',
        'check_in_type',
    ];


    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];


    public function organizer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
