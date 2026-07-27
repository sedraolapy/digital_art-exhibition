<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
    ];

    public function occurrences()
    {
        return $this->hasMany(EventOccurrence::class);
    }

    public function diamondSponsors()
    {
        return $this->belongsToMany(Sponsor::class, 'cycle_sponsors')
            ->where('type', 'diamond');
    }

    public function sponsors()
    {
        return $this->belongsToMany(
            Sponsor::class,
            'cycle_sponsors',
            'cycle_id',
            'sponsor_id'
        )
        ->using(CycleSponsor::class);
    }
}
