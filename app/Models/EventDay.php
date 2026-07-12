<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventDay extends Model
{
    protected $fillable = [
        'event_occurrence_id',
        'date',
    ];

    public function occurrence()
    {
        return $this->belongsTo(EventOccurrence::class);
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }
}
