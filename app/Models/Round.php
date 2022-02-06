<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $count
 * @property int    $correct_answer_id
 * @property Answer $correctAnswer
 * @property Game   $game
 */
class Round extends Model
{
    protected $table = 'rounds';

    protected $fillable = [
        'game_id',
        'count',
        'correct_answer_id',
    ];

    public function game() : BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function answers() : HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function correctAnswer() : BelongsTo
    {
        return $this->belongsTo(Answer::class,
            'correct_answer_id');
    }

    public function generateAnswers() : void
    {
        $client   = new Client;
        $count = 0;
        while ($count < 3) {
            $number   = rand();
            $response = $client->request('GET',
                "http://numbersapi.com/{$number}?fragment&notfound=floor&json");

            $result = json_decode($response->getBody()
                ->getContents());

            $previousRoundIds = $this->getPreviousRoundNumbers();
            if (
                in_array($result->number,
                    $previousRoundIds)
            ) {
                continue;
            }

            // Check if answer option already exists for this round
            $answerInvalid = $this->answers()
                ->where('number',
                    $result->number)
                ->orWhere('text',
                    $result->text)
                ->where('round_id',
                    $this->id)
                ->exists();
            if ($answerInvalid) {
                continue;
            }
            $answer = new Answer([
                'round_id' => $this->id,
                'number'   => $result->number,
                'text'     => $result->text,
            ]);

            $answer->save();
            $count++;
        }

        $this->setCorrectAnswer();
    }

    private function setCorrectAnswer() : void
    {
        $answer = $this->answers()
            ->inRandomOrder()
            ->first();

        $this->correct_answer_id = $answer->id;
        $this->saveOrFail();
    }

    private function getPreviousRoundNumbers() : array
    {
        $ids = [];
        foreach ($this->game->rounds as $round) {
            if ($round->correctAnswer) {
                $ids[] = $round->correctAnswer->number;
            }
        };

        return $ids;
    }
}