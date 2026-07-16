<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OccurrenceSponsor extends Model
{
    protected $table = 'occurrence_sponsors';

    protected $fillable = [
        'event_occurrence_id',
        'sponsor_id',
    ];

    public function occurrence()
    {
        return $this->belongsTo(EventOccurrence::class, 'event_occurrence_id');
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }
}
