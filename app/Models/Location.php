<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
    ];

    public function occurrences()
    {
        return $this->hasMany(EventOccurrence::class);
    }
}
