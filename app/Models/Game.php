<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $status
 */
class Game extends Model
{
    const STATUS_WON         = 'WON';
    const STATUS_LOST        = 'LOST';
    const STATUS_IN_PROGRESS = 'IN_PROGRESS';

    protected $fillable = [
        'status',
    ];

    public function rounds(): HasMany
    {
        return $this->hasMany(Round::class);
    }

    public function latestRound(): HasOne
    {
        return $this->hasOne(Round::class)
            ->latest('created_at');
    }

    public function getCurrentRound(): Round
    {
        $latestRound = $this->latestRound;
        if ( !$latestRound) {
            $count = 1;
        } elseif ($latestRound->count === 20) {
            return $latestRound;
        } else {
            $count = $latestRound->count + 1;
        }
        $nextRound = new Round([
            'game_id' => $this->id,
            'count'   => $count,
            'correct' => false,
        ]);
        $nextRound->save();

        $nextRound->generateAnswers();

        return $nextRound;
    }
}