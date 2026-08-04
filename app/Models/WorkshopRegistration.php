<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkshopRegistration extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'workshop_id',
        'status',
    ];

    protected $casts = [
        'status' => BookingStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

}
