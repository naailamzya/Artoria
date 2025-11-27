<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'curator_id',
        'title',
        'description',
        'rules',
        'prizes',
        'banner_image',
        'start_date',
        'end_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function curator()
    {
        return $this->belongsTo(User::class, 'curator_id');
    }

    public function entries()
    {
        return $this->hasMany(ChallengeEntry::class);
    }

    public function artworks()
    {
        return $this->belongsToMany(Artwork::class, 'challenge_entries')
                    ->withTimestamps()
                    ->withPivot('is_winner');
    }

    public function winners()
    {
        return $this->entries()->where('is_winner', true)->with('artwork');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->where('start_date', '<=', now())
                     ->where('end_date', '>=', now());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'active')
                     ->where('start_date', '>', now());
    }

    public function scopeEnded($query)
    {
        return $query->where('status', 'ended')
                     ->orWhere(function($q) {
                         $q->where('end_date', '<', now());
                     });
    }

    public function isActive(): bool
    {
        return $this->status === 'active' 
            && Carbon::parse($this->start_date)->isPast()
            && Carbon::parse($this->end_date)->isFuture();
    }

    public function hasEnded(): bool
    {
        return Carbon::parse($this->end_date)->isPast();
    }

    public function canAcceptSubmissions(): bool
    {
        return $this->isActive() && !$this->hasEnded();
    }

    public function userHasEntered(User $user): bool
    {
        return $this->entries()->where('user_id', $user->id)->exists();
    }

    public function getBannerUrlAttribute()
    {
        return $this->banner_image 
            ? asset('storage/' . $this->banner_image)
            : asset('images/default-challenge.png');
    }
}