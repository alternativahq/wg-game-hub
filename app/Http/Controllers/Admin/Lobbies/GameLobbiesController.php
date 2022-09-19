<?php

namespace App\Http\Controllers\Admin\Lobbies;

use App\Actions\GameLobby\GameLobbyStartSignalAction;
use App\Enums\ChatRoomType;
use App\Models\ChatRoom;
use App\Models\Game;
use Inertia\Inertia;
use App\Models\Asset;
use App\Enums\GameStatus;
use App\Models\GameLobby;
use App\Enums\GameLobbyType;
use App\Enums\GameLobbyStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLobbyRequest;
use App\Http\Requests\UpdateLobbyRequest;
use App\Http\Resources\GameLobbyResource;

class GameLobbiesController extends Controller
{
    public function create(Game $game)
    {
        $assets = Asset::get(['id', 'name']);
        $gameTypes = GameLobbyType::toSelect();
        $gameStatus = GameLobbyStatus::toSelect();

        return Inertia::render('Admin/Lobbies/AddGameLobby', [
            'game' => $game,
            'assets' => $assets,
            'gameTypes' => $gameTypes,
            'gameStatus' => $gameStatus,
        ]);
    }

    public function store(StoreLobbyRequest $request, Game $game, GameLobbyStartSignalAction $gameLobbyStartSignal)
    {
        $request->merge(['gameId' => $game->id]);
        $httpResponse = $gameLobbyStartSignal->execute(request: $request);

        if ($httpResponse->successful()) {
            session()->flash('success', 'new lobby got added successfully!');
        } else {
            session()->flash('error', 'Something went wrong, please try again later.');
        }

        return redirect()->route('admin-gameLobbies.show', $game->id);
    }

    public function edit(GameLobby $gameLobby)
    {
        $assets = Asset::get(['id', 'name']);
        $gameTypes = GameLobbyType::toSelect();
        $gameStatus = GameLobbyStatus::toSelect();

        return Inertia::render('Admin/Lobbies/EditGameLobby', [
            'gameLobby' => new GameLobbyResource($gameLobby),
            'assets' => $assets,
            'gameTypes' => $gameTypes,
            'gameStatus' => $gameStatus,
        ]);
    }

    public function update(UpdateLobbyRequest $request, GameLobby $gameLobby)
    {
        $gameLobby->update($request->validated());
        session()->flash('success', 'lobby updated successfully!');
        return redirect()->route('admin-gameLobbies.show', $gameLobby->game->id);
    }

    public function destroy(GameLobby $gameLobby)
    {
        $gameLobby->delete();
        session()->flash('success', 'lobby deleted successfully!');
        return redirect()->route('admin-gameLobbies.show', $gameLobby->game->id);
    }
}
