<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\PermissionEnum;
use App\Enums\Role;
use App\Enums\RoleEnum;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements FilamentUser , HasMedia
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
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
        ];
    }

    public function votes(){
        return $this->hasMany(Vote::class);
    }

    public function lectureAttendance()
    {
        return $this->hasMany(LectureAttendance::class);
    }

    public function workshopAttendance()
    {
        return $this->hasMany(WorkshopAttendance::class);
    }

    public function exhibitorProfile()
    {
        return $this->hasOne(ExhibitorProfile::class);
    }

    public function exhibitorProfiles()
    {
        return $this->hasMany(ExhibitorProfile::class);
    }

    public function socialLinks()
    {
        return $this->morphMany(SocialLink::class, 'linkable');
    }

    public function eventAttendances()
    {
        return $this->hasMany(EventAttendance::class);
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

        if ($this->hasRole(RoleEnum::SUPER_ADMIN->value)) {
            return true;
        }

        if (! $this->hasAnyRole([
            RoleEnum::CONTENT_MANAGER->value,
            RoleEnum::EXHIBITOR_APPLICATION_MANAGER->value,
            RoleEnum::ORGANIZER->value,
        ])) {
            return false;
        }

        return $this->hasPermissionTo(
            PermissionEnum::ACCESS_ADMIN_PANEL->value
        );
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format('webp')
            ->quality(70)
            ->nonQueued();
    }


}
