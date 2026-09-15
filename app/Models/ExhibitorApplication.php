<?php

namespace App\Models;

use App\Enums\ExhibitorStatus;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class ExhibitorApplication extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'status',
        'experience_years',
        'portfolio_url',
        'bio',
        'event_occurrence_id',
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
        return $this->belongsTo(EventOccurrence::class, 'event_occurrence_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('application_image')
            ->singleFile();
    
        $this->addMediaCollection('application_cv')
            ->singleFile();
    }
}
