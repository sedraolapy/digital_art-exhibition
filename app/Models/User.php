<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Role;
use Database\Factories\UserFactory;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $guard_name = 'admin';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'role',
        'qr_token',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class,
        ];
    }

    public function votes(){
        return $this->hasMany(Vote::class);
    }

    public function lectureAttendance()
    {
        return $this->hasMany(LectureAttendance::class);
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function exhibitorProfile()
    {
        return $this->hasOne(ExhibitorProfile::class);
    }

    public function getFilamentName(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }

    public function getNameAttribute(): string
    {
        return $this->getFilamentName();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === Role::ADMIN->value && $this->guard === 'admin';
    }


}
