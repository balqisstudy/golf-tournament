<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    protected $table = 'scores';
    protected $primaryKey = 'ScoreID';
    public $timestamps = true;

    protected $fillable = [
        'UserID',
        'TournamentID',
        'Round',
        'Hole',
        'Strokes',
        'Par',
    ];

    protected $casts = [
        'Round' => 'integer',
        'Hole' => 'integer',
        'Strokes' => 'integer',
        'Par' => 'integer',
    ];

    /**
     * Relationship with User (Player)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    /**
     * Relationship with Tournament
     */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class, 'TournamentID', 'TournamentID');
    }

    /**
     * Calculate score relative to par
     */
    public function getScoreToPar()
    {
        return $this->Strokes - $this->Par;
    }

    /**
     * Get score description (Eagle, Birdie, Par, Bogey, etc.)
     */
    public function getScoreDescription()
    {
        $diff = $this->getScoreToPar();
        
        if ($diff <= -2) return 'Eagle';
        if ($diff == -1) return 'Birdie';
        if ($diff == 0) return 'Par';
        if ($diff == 1) return 'Bogey';
        if ($diff == 2) return 'Double Bogey';
        return 'Triple Bogey+';
    }
}
