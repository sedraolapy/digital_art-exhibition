<?php

namespace App\Models;

use App\Enums\ExhibitorStatus;
use Illuminate\Database\Eloquent\Model;

class ExhibitorProfile extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'experience_years',
        'cv_url',
        'portfolio_url',
        'bio',
        'image_url',
        'event_occurrence_id',
    ];

    protected $casts = [
        'status' => ExhibitorStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'exhibitor_id');
    }

    public function socialLinks()
    {
        return $this->morphMany(SocialLink::class, 'linkable');
    }

    public function userHasVoted()
    {
        return $this->votes()->where('user_id', auth()->id())->exists();
    }

    public function occurrence()
    {
        return $this->belongsTo(EventOccurrence::class);
    }

}
