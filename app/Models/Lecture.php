<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lecture extends Model
{
    protected $fillable = [
        'event_day_id',
        'title',
        'description',
        'speaker_name',
        'max_seats',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time'   => 'datetime:H:i',
    ];

    public function day()
    {
        return $this->belongsTo(EventDay::class, 'event_day_id');
    }

    public function attendance()
    {
        return $this->hasMany(LectureAttendance::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
