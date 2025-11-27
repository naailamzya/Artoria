<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'challenge_id',
        'artwork_id',
        'user_id',
        'is_winner',
    ];

    protected function casts(): array
    {
        return [
            'is_winner' => 'boolean',
        ];
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    public function artwork()
    {
        return $this->belongsTo(Artwork::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWinners($query)
    {
        return $query->where('is_winner', true);
    }
}