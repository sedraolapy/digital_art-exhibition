<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    protected $fillable = [
        'user_id',
        'exhibitor_id',
        'event_occurrence_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exhibitor(): BelongsTo
    {
        return $this->belongsTo(ExhibitorProfile::class);
    }

    public function eventOccurrence(): BelongsTo
    {
        return $this->belongsTo(EventOccurrence::class);
    }
}
