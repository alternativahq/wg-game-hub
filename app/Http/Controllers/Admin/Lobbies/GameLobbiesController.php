<?php

namespace App\Http\Controllers\Admin\Lobbies;

use App\Http\Resources\GameLobbyActivityLogResource;
use App\Models\Game;
use Inertia\Inertia;
use App\Models\Asset;
use App\Models\ChatRoom;
use App\Enums\GameStatus;
use App\Models\GameLobby;
use App\Enums\ChatRoomType;
use App\Enums\GameLobbyType;
use App\Enums\GameLobbyStatus;
use App\Http\Controllers\Controller;
use App\Enums\GameLobbyAlgorithmsType;
use App\Http\Requests\StoreLobbyRequest;
use App\Http\Requests\UpdateLobbyRequest;
use App\Http\Resources\GameLobbyResource;
use App\Actions\GameLobby\GameLobbyStartSignalAction;

class GameLobbiesController extends Controller
{
    public function create(Game $game)
    {
        $assets = Asset::get(['id', 'name']);
        $gameTypes = GameLobbyType::toSelect();
        $gameStatus = GameLobbyStatus::toSelect();
        $gameAlgorithms = GameLobbyAlgorithmsType::toSelect();

        return Inertia::render('Admin/Lobbies/AddGameLobby', [
            'game' => $game,
            'assets' => $assets,
            'gameTypes' => $gameTypes,
            'gameStatus' => $gameStatus,
            'gameAlgorithms' => $gameAlgorithms,
        ]);
    }

    public function store(StoreLobbyRequest $request, Game $game, GameLobbyStartSignalAction $gameLobbyStartSignal)
    {
        $request->merge(['game_id' => $game->id]);
        $httpResponse = $gameLobbyStartSignal->execute(request: $request);

        if ($httpResponse->successful()) {
            session()->flash('success', 'new lobby got added successfully!');
        } else {
            session()->flash('error', 'Something went wrong, please try again later.');
        }

        return redirect()->route('admin-games.show', $game->id);
    }

    public function show(GameLobby $gameLobby)
    {
        return Inertia::render('Admin/Lobbies/ShowGameLobby', [
            'gameLobby' => new GameLobbyResource($gameLobby),
            'gameLobbyActivityLogs' => GameLobbyActivityLogResource::collection(
                $gameLobby
                    ->activityLogs()
                    ->orderBy('created_at')
                    ->get(),
            ),
            'usersCount' => $gameLobby->users()->count(),
        ]);
    }

    public function details(GameLobby $gameLobby)
    {
        // return $gameLobby->usersAchievements()->where('user_id', auth()->user()->id)->get();
        $gameLobby->load(
            'game:id,name,description',
            'users:id,name,last_name,image,username',
            'asset:id,name,symbol',
        );
        $gameLobby->load([
            'scores' => function ($q) {
                return $q->orderBy('rank')->limit(10);
            },
        ]);
        return Inertia::render('Games/Lobbies/Details', [
            'gameLobby' => new GameLobbyResource($gameLobby),
            'currentUserScore' => function () use ($gameLobby) {
                return auth()->user()
                    ? $gameLobby
                        ->scores()
                        ->where('user_id', auth()->user()->id)
                        ->first()
                    : [];
            },
        ]);
    }

    public function destroy(GameLobby $gameLobby)
    {
        $gameLobby->delete();
        session()->flash('success', 'lobby deleted successfully!');
        return redirect()->route('admin-games.show', $gameLobby->game->id);
    }
}
