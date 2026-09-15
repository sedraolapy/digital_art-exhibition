<?php

namespace App\Models;

use App\Enums\ExperienceStatus;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Experience extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'status'  => ExperienceStatus::class,
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('experience_gallery');
    }


}
