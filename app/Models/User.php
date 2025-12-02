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
        'brand_name',
        'portfolio_url',
        'portofolio_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // RELATIONS
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

    public function isActive(): bool
    {
        if (!isset($this->status) || empty($this->status) || is_null($this->status)) {
            return true;
        }
        
        return $this->status === 'active';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isBanned(): bool
    {
        return $this->status === 'banned';
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    public function hasPendingCuratorApplication(): bool
    {
        return $this->isMember() && 
               $this->status === 'pending' &&
               ($this->brand_name || $this->getPortfolioUrlAttribute());
    }

    public function hasRejectedCuratorApplication(): bool
    {
        return $this->isMember() && 
               ($this->brand_name || $this->getPortfolioUrlAttribute()) &&
               $this->status === 'active' &&
               !$this->isCurator();
    }

    public function hasActiveCuratorApplication(): bool
    {
        return $this->isMember() && 
               $this->status === 'pending' &&
               ($this->brand_name || $this->getPortfolioUrlAttribute());
    }

    public function canApplyAsCurator(): bool
    {
        return $this->isMember() && 
               !$this->brand_name && 
               !$this->getPortfolioUrlAttribute() &&
               $this->artworks()->count() >= 3;
    }

    public function markAsRejectedCurator(): void
    {
        if ($this->isMember() && $this->status === 'pending') {
            $this->update(['status' => 'active']);
            session(['curator_rejected_user_id' => $this->id]);
        }
    }

    public function approveAsCurator(): void
    {
        if ($this->isMember() && $this->status === 'pending') {
            $this->update([
                'role' => 'curator',
                'status' => 'active'
            ]);
        }
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

    public function getPortfolioUrlAttribute()
    {
        if (isset($this->attributes['portfolio_url'])) {
            return $this->attributes['portfolio_url'];
        }
        
        if (isset($this->attributes['portofolio_url'])) {
            return $this->attributes['portofolio_url'];
        }
        
        return null;
    }

    public function setPortfolioUrlAttribute($value)
    {
        if (isset($this->attributes['portfolio_url'])) {
            $this->attributes['portfolio_url'] = $value;
        } elseif (isset($this->attributes['portofolio_url'])) {
            $this->attributes['portofolio_url'] = $value;
        } else {
            $this->attributes['portfolio_url'] = $value;
        }
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

    public function scopeWithCuratorInfo($query)
    {
        return $query->where(function($q) {
            $q->whereNotNull('brand_name')
              ->orWhereNotNull('portfolio_url')
              ->orWhereNotNull('portofolio_url');
        });
    }

    public function hasLiked(Artwork $artwork): bool
    {
        return $this->likes()->where('artwork_id', $artwork->id)->exists();
    }

    public function hasFavorited(Artwork $artwork): bool
    {
        return $this->favorites()->where('artwork_id', $artwork->id)->exists();
    }

    public function submitCuratorApplication(array $data): bool
    {
        if (!$this->canApplyAsCurator()) {
            return false;
        }

        $this->update([
            'brand_name' => $data['brand_name'] ?? null,
            'portfolio_url' => $data['portfolio_url'] ?? null,
            'status' => 'pending',
        ]);

        return true;
    }

    public function getStatusSafe()
    {
        if (isset($this->attributes['status'])) {
            return $this->attributes['status'];
        }
        
        if (property_exists($this, 'status') && isset($this->status)) {
            return $this->status;
        }
        
        return null;
    }
}