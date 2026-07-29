<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VotingResult extends Model
{
    protected $table = 'votes';

    public function exhibitor()
    {
        return $this->belongsTo(
            ExhibitorProfile::class,
            'exhibitor_id'
        );
    }

    public function eventOccurrence()
    {
        return $this->belongsTo(
            EventOccurrence::class,
            'event_occurrence_id'
        );
    }
}