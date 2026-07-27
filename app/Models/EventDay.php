<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventDay extends Model
{
    protected $fillable = [
        'day_number',
        'event_occurrences_id',
        'date',
    ];

    public function occurrence()
    {
        return $this->belongsTo(EventOccurrence::class, 'event_occurrences_id');
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }
    public function getDayNumberAttribute(): string
    {
        return 'Day ' . $this->attributes['day_number'];
    }


}
