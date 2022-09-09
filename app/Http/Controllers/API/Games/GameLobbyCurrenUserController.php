<?php

namespace App\Http\Controllers\API\Games;

use App\Models\GameLobby;
use App\Http\Controllers\Controller;

class GameLobbyCurrenUserController extends Controller
{
    public function __invoke(GameLobby $gameLobby)
    {
        $user = $gameLobby->scores()->where('user_id',request()->user()->id)->first() ?? [];
        return response()->json($user); 
    }
}
