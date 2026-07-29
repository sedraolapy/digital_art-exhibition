<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LectureAttendance extends Model
{
    protected $table = 'lecture_attendance';

    protected $fillable = [
        'user_id',
        'lecture_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
}
