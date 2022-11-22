<?php

namespace App\Http\Controllers\GameLobbies;

use Auth;
use Inertia\Inertia;
use App\Models\GameLobby;
use App\Models\GameLobbyUser;
use App\Enums\GameLobbyStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameLobbyResource;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Internal\GameLobbyServiceAPI;

class GameLobbyPlayCanvasController extends Controller
{
    public function __construct(protected GameLobbyServiceAPI $gameLobbyServiceAPI)
    {
    }

    public function __invoke(GameLobby $gameLobby)
    {
        $gameLobbyId = $gameLobby->id;
        $sessionId = $gameLobby->session_id;
        $userId = auth()->user()->id;
        $errorMessage = '';
        $check = $gameLobby->users()->where('user_id', $userId)->first();
        if($check){
            $response = $this->gameLobbyServiceAPI->getToken($gameLobbyId, $userId);
            if(!$response->failed()){
                $token = $response->json()['token'];
                return view("PlayCanvas", compact('userId', 'gameLobbyId','sessionId', 'token'));
            }
        }
        $errorMessage = isset($response) ? 'Your token has Expired.' : 'Your are not in this gameLobby.';
        session()->flash('error', $errorMessage);
        return redirect()->route('game-lobbies.show', $gameLobby->id);
    }
}
