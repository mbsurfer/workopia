<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'avater',
        'password',
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

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function bookmarkedJobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'job_user_bookmarks')->withTimestamps();
    }

    public function hasBookmarked(Job $job): bool
    {
        return $this->bookmarkedJobs()->where('job_id', $job->id)->exists();
    }

    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class, 'user_id');
    }
}
