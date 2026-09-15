<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Member extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'role',
        'bio',
        'portfolio_url',
    ];


    public function socialLinks()
    {
        return $this->morphMany(SocialLink::class, 'linkable');
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('members')
            ->singleFile();
    }
}
