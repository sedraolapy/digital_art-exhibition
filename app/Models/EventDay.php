<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventDay extends Model
{
    protected $fillable = [
        'day_number',
        'event_occurrence_id',
        'date',
    ];

    public function occurrence()
    {
        return $this->belongsTo(EventOccurrence::class, 'event_occurrence_id');
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }
    public function getDayLabelAttribute(): string
    {
        return 'Day ' . $this->day_number;
    }

    public function attendances()
    {
        return $this->hasMany(EventAttendance::class, 'event_day_id');
    }


}
