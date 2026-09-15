<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ExhibitorProfile extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'experience_years',
        'portfolio_url',
        'bio',
        'event_occurrence_id',
        'category_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'exhibitor_id');
    }

    public function eventOccurrence()
    {
        return $this->belongsTo(EventOccurrence::class, 'event_occurrence_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function socialLinks()
    {
        return $this->morphMany(SocialLink::class, 'linkable');
    }


    public function bookings()
    {
        return $this->hasManyThrough(
            Booking::class,
            User::class,
            'id',       // المفتاح على users يلي بيربط مع exhibitor_profiles.user_id
            'user_id',  // المفتاح على bookings يلي بيربط مع users.id
            'user_id',  // المفتاح المحلي على exhibitor_profiles
            'id'        // المفتاح المحلي على users
        );
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('exhibitor_image')
            ->singleFile();
    
        $this->addMediaCollection('exhibitor_cv')
            ->useDisk('private')
            ->singleFile();
    }

}
