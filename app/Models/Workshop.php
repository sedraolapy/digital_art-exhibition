<?php

namespace App\Models;

use App\Enums\WorkshopStatus;
use Illuminate\Database\Eloquent\Model;use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Workshop extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'speaker_name',
        'max_seats',
        'date',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'status' => WorkshopStatus::class,
    ];

    public function attendance()
    {
        return $this->hasMany(WorkshopAttendance::class);
    }

    public function registrations()
    {
        return $this->hasMany(WorkshopRegistration::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('workshops')
            ->singleFile();
    
        $this->addMediaCollection('workshop_gallery');
    }
}
