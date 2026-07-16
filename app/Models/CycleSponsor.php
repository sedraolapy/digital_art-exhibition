<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CycleSponsor extends Model
{
    protected $table = 'cycle_sponsors';

    protected $fillable = [
        'cycle_id',
        'sponsor_id',
    ];

    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }
}
