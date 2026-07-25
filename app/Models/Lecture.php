<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Lecture extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'event_day_id',
        'title',
        'description',
        'speaker_name',
        'max_seats',
        'start_time',
        'end_time',
    ];

    public function day()
    {
        return $this->belongsTo(EventDay::class, 'event_day_id');
    }

    public function attendance()
    {
        return $this->hasMany(LectureAttendance::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getDateAttribute()
    {
        return $this->day->date;
    }

    public function getHasEndedAttribute()
    {
        $endDateTime = Carbon::parse($this->date . ' ' . $this->end_time);

        return now()->greaterThan($endDateTime);
    }


    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format('webp')
            ->quality(70)
            ->nonQueued();
    }
}
