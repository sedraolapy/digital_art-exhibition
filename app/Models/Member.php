<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    protected $fillable = [
        'name',
        'role',
        'bio',
        'portfolio_url',
        'image_url',
    ];


    public function socialLinks()
    {
        return $this->morphMany(SocialLink::class, 'linkable');
    }

}
