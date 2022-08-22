<?php

namespace App\Http\Controllers\Admin;
use App\Models\Game;
use Inertia\Inertia;
use App\Models\Asset;
use App\Enums\GameStatus;
use App\Models\GameLobby;
use App\Enums\GameLobbyType;
use Illuminate\Http\Request;
use App\Enums\GameLobbyStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Requests\StoreLobbyRequest;
use App\Http\Requests\UpdateLobbyRequest;
use App\Http\Resources\GameLobbyResource;

class GameLobbiesController extends Controller
{
    public function create(Game $game)
    {
        $assets = Asset::get(['id', 'name']);
        $gameTypes = GameLobbyType::toSelect();
        $gameStatuss = GameLobbyStatus::toSelect();

        return Inertia::render('Admin/AddGameLobby',[
            'assets' => $assets, 
            'game' => $game, 
            'gameTypes' => $gameTypes,
            'gameStatuss' => $gameStatuss
        ]);
    }

    public function store(StoreLobbyRequest $request,Game $game)
    {
        $game->gameLobbies()->create(array_merge($request->validated(),['available_spots'=>$request->max_players]));
        session()->flash('success', 'new lobby got added successfully!');
        return redirect()->route('admin-game-lobbies',$game->id);
    }

    public function edit(GameLobby $gameLobby)
    {
        return Inertia::render('Admin/EditGameLobby', [
            'gameLobby' => new GameLobbyResource($gameLobby),
        ]);
    }

    public function update(UpdateLobbyRequest $request, Game $game, GameLobby $gameLobby)
    {
        $gameLobby->update($request->validated());
        session()->flash('success', 'lobby updated successfully!');
        return redirect()->route('admin-game-lobbies',$game->id);
    }

    public function destroy(Game $game, GameLobby $gameLobby)
    {
        // dd($game->id);
        $gameLobby->delete();
        session()->flash('success', 'lobby deleted successfully!');
        return redirect()->route('admin-game-lobbies', $game->id);
    }
}