<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class TriviaController extends Controller
{
    public function play(int $id)
    {
        $game = Game::find($id);
        if ( !$game) {
            return redirect(route('home'));
        }

        /** @var Game $game */
        $round = $game->getCurrentRound();
        if ($round->count === 20) {
            return redirect(route('win',
                ['id' => $id]));
        }

        return view('game',
            [
                'options' => $round->answers,
                'round'   => $round,
            ]);

    }

    public function submitAnswer(
        Request $request,
        int $id
    ) {
        $request->validate([
            'answer' => ['required'],
        ]);
        $answer = $request->get('answer');
        $game   = Game::find($id);
        if ( !$game) {
            return redirect(route('home'));
        }
        if ($game->latestRound->correctAnswer->number == $answer) {
            return redirect(route('play',
                ['id' => $id]));
        }

        $game->status = Game::STATUS_LOST;
        $game->saveOrFail();

        return redirect(route('lose',
            ['id' => $id]));
    }

    public function lose(int $id)
    {
        $game = Game::find($id);
        if ( !$game) {
            return redirect(route('home'));
        }
        $round = $game->latestRound;

        return view('lost',
            [
                'options' => $round->answers,
                'round'   => $round,
            ]);
    }

    public function win(int $id)
    {
        $game = Game::find($id);
        if ( !$game) {
            return redirect(route('home'));
        }

        return view('won');
    }
}