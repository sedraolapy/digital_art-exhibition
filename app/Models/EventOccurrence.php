<?php

namespace App\Models;

use App\Enums\EventOccurrenceStatus;
use Illuminate\Database\Eloquent\Model;

class EventOccurrence extends Model
{

    protected $fillable = [
        'title',
        'cycle_id',
        'location_id',
        'start_date',
        'end_date',
        'status',
        'is_voting_enabled',
    ];

    protected $casts = [
        'status' => EventOccurrenceStatus::class,
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function days()
    {
        return $this->hasMany(EventDay::class, 'event_occurrences_id');
    }


    public function exhibitors()
    {
        return $this->hasMany(ExhibitorProfile::class);
    }

    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class, 'occurrence_sponsors')
            ->whereIn('type', ['gold', 'silver']);
    }
}
