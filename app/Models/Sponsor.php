<?php

namespace App\Models;

use App\Enums\SponsorType;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class Sponsor extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'type',
    ];

    protected $casts = [
        'type' => SponsorType::class,
    ];

    public function cycles()
    {
        return $this->belongsToMany(
            Cycle::class,
            'cycle_sponsors',
            'sponsor_id',
            'cycle_id'
        )
        ->using(CycleSponsor::class);
    }

    public function occurrences()
    {
        return $this->belongsToMany(
            EventOccurrence::class,
            'occurrence_sponsors',
            'sponsor_id',
            'event_occurrence_id'
        )
        ->using(OccurrenceSponsor::class);
    }

    protected static function booted(): void
    {
        static::deleting(function (Sponsor $sponsor) {
            $sponsor->cycles()->detach();
            $sponsor->occurrences()->detach();
        });
    }
    
}
