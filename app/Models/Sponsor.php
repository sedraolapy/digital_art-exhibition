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

//  رعاة ألماسيين مرتبطين بالدورة
    public function cycles()
    {
        return $this->belongsToMany(Cycle::class, 'cycle_sponsor')
            ->where('type', SponsorType::DIAMOND);
    }

//  رعاة دهبي + فضي مرتبطين بالـ occurrence (المحافظة ضمن الدورة)
    public function occurrences()
    {
        return $this->belongsToMany(EventOccurrence::class, 'occurrence_sponsor')
            ->whereIn('type', [
                SponsorType::GOLD,
                SponsorType::SILVER,
            ]);
    }
}
