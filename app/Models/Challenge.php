<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'curator_id',
        'title',
        'description',
        'rules',
        'rewards',
        'deadline',
        'status'
    ];

    protected function casts(): array
    {
        return [
        'deadline' => 'datetime',
    ];
    }

    public function curator()
    {
        return $this->belongsTo(User::class, 'curator_id');
    }

    public function submissions()
    {
        return $this->hasMany(ChallengeSubmission::class);
    }

    public function winners()
    {
        return $this->hasMany(ChallengeWinner::class);
    }
}
