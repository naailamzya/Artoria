<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'display_name',
        'profile_picture',
        'bio',
        'instagram_link',
        'github_link',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function challenges()
    {
        return $this->hasMany(Challenge::class, 'curator_id');
    }

    public function challengeEntries()
    {
        return $this->hasMany(ChallengeEntry::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    public function isCurator(): bool
    {
        return $this->role === 'curator';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function hasLiked(Artwork $artwork): bool
    {
        return $this->likes()->where('artwork_id', $artwork->id)->exists();
    }

    public function hasFavorited(Artwork $artwork): bool
    {
        return $this->favorites()->where('artwork_id', $artwork->id)->exists();
    }

    public function scopeMembers($query)
    {
        return $query->where('role', 'member');
    }

    public function scopeCurators($query)
    {
        return $query->where('role', 'curator');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getDisplayNameAttribute($value)
    {
        return $value ?? $this->name;
    }

    public function getProfilePictureUrlAttribute()
    {
        return $this->profile_picture 
            ? asset('storage/' . $this->profile_picture)
            : asset('images/default-avatar.png');
    }

}