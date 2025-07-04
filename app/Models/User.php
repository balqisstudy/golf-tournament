<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'Name',
        'Email',
        'Password',
        'Role',
        'RegistrationDate',
        'NotificationID',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'Password',
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
            'RegistrationDate' => 'datetime',
            'Password' => 'hashed',
        ];
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'UserID';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Relationship with scores
     */
    public function scores()
    {
        return $this->hasMany(Score::class, 'UserID', 'UserID');
    }

    /**
     * Relationship with tournaments through scores
     */
    public function tournaments()
    {
        return $this->belongsToMany(Tournament::class, 'scores', 'UserID', 'TournamentID', 'UserID', 'TournamentID')
                    ->withPivot('Round', 'Hole', 'Strokes', 'Par');
    }

    /**
     * Get user's score for a specific tournament
     */
    public function getScoreForTournament($tournamentId)
    {
        return $this->scores()->where('TournamentID', $tournamentId)->sum('Strokes');
    }

    /**
     * Relationship with notifications
     */
    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'user_notifications', 'UserID', 'NotificationID')
                    ->withPivot(['RecipientID', 'Timestamp']);
    }

    /**
     * Scope to filter users who are players
     */
    public function scopePlayers($query)
    {
        return $query->where('Role', 'player');
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->Role === 'admin';
    }

    /**
     * Check if user is player
     */
    public function isPlayer()
    {
        return $this->Role === 'player';
    }
}
