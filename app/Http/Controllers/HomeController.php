<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function startGame()
    {
        $game = new Game(['status' => Game::STATUS_IN_PROGRESS]);
        $game->save();

        return redirect()->route('play', ['id' => $game->id]);
    }
}