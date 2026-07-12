<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventAttendance extends Model
{
    protected $table = 'event_attendance';

    protected $fillable = [
        'user_id',
        'event_day_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eventDay()
    {
        return $this->belongsTo(EventDay::class);
    }
}
