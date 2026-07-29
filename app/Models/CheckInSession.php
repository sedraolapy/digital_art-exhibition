<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckInSession extends Model
{
    protected $fillable = [
        'user_id',
        'event_occurrence_id',
        'token',
        'expires_at',
        'is_active',
    ];


    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];


    public function organizer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function event()
    {
        return $this->belongsTo(EventOccurrence::class);
    }
}