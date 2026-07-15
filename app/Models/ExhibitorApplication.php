<?php

namespace App\Models;

use App\Enums\ExhibitorStatus;
use Illuminate\Database\Eloquent\Model;

class ExhibitorApplication extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'experience_years',
        'cv_file',
        'portfolio_url',
        'bio',
        'image_url',
        'event_occurrences_id',
        'category_id',
    ];

    protected $casts = [
        'status' => ExhibitorStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function socialLinks()
    {
        return $this->morphMany(SocialLink::class, 'linkable');
    }

    public function eventOccurrence()
    {
        return $this->belongsTo(EventOccurrence::class, 'event_occurrences_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


}
