<?php

namespace App\Models;

use App\Enums\CycleStatus;
use App\Enums\SponsorType;
use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status'
    ];

    protected $casts = [
        'status' => CycleStatus::class,
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function occurrences()
    {
        return $this->hasMany(EventOccurrence::class);
    }

    public function diamondSponsors()
    {
        return $this->belongsToMany(Sponsor::class, 'cycle_sponsors')
            ->where('sponsors.type', SponsorType::DIAMOND->value);
    }

    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class,
            'cycle_sponsors',
            'cycle_id',
            'sponsor_id'
        )->using(CycleSponsor::class);
    }
}
