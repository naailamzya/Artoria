<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeWinner extends Model
{
    use HasFactory;

    protected $fillable = [
        'challenge_id',
        'submission_id',
        'rank',
    ];

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    public function submission()
    {
        return $this->belongsTo(ChallengeSubmission::class, 'submission_id');
    }
}
