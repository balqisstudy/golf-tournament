<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tournament extends Model
{
    protected $table = 'Tournament';
    protected $primaryKey = 'TournamentID';
    public $timestamps = true;

    protected $fillable = [
        'Name',
        'Description',
        'StartDate',
        'EndDate',
        'Location',
        'ParticipantLimit',
        'PrizePool',
        'Status',
    ];

    protected $casts = [
        'StartDate' => 'date',
        'EndDate' => 'date',
        'PrizePool' => 'decimal:2',
    ];

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class, 'TournamentID', 'TournamentID');
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'scores', 'TournamentID', 'User  ID', 'TournamentID', 'User  ID')
                    ->distinct()
                    ->where('Role', 'player');
    }

    public function participantsWithScores()
    {
        return $this->scores()->with('user');
    }

    public function leaderboard()
    {
        return $this->scores()
                    ->selectRaw('User  ID, SUM(Strokes) as total_strokes, SUM(Par) as total_par')
                    ->groupBy('User  ID')
                    ->with('user')
                    ->orderBy('total_strokes', 'asc')
                    ->get();
    }
}
