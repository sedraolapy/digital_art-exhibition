<?php

namespace App\Models;

use App\Enums\SponsorType;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = [
        'name',
        'logo_url',
        'type',
    ];

    protected $casts = [
        'type' => SponsorType::class,
    ];

    public function cycles()
    {
        return $this->belongsToMany(Cycle::class, 'cycle_sponsors', 'sponsor_id', 'cycle_id');
    }

    public function occurrences()
    {
        return $this->belongsToMany(EventOccurrence::class, 'occurrence_sponsors', 'sponsor_id', 'event_occurrence_id');
    }
}
