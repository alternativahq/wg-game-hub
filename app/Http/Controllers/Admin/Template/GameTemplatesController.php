<?php

namespace App\Http\Controllers\Admin\Template;

use App\Models\Game;
use Inertia\Inertia;
use App\Models\Asset;
use App\Models\ChatRoom;
use App\Enums\GameStatus;
use App\Models\GameLobby;
use App\Enums\ChatRoomType;
use App\Enums\GameLobbyType;
use App\Enums\GameLobbyStatus;
use App\Models\GameLobbyTemplate;
use App\Http\Controllers\Controller;
use App\Enums\GameLobbyAlgorithmsType;
use App\Http\Requests\StoreLobbyRequest;
use App\Http\Requests\StoreLobbyTemplateRequest;
use App\Http\Requests\UpdateLobbyTemplateRequest;
use App\Http\Resources\GameLobbyTemplateResource;
use App\Actions\GameLobby\GameLobbyStartSignalAction;

class GameTemplatesController extends Controller
{
    public function createLobby(GameLobbyTemplate $gameTemplate)
    {
        $assets = Asset::get(['id', 'name']);
        $gameTypes = GameLobbyType::toSelect();
        $gameAlgorithms = GameLobbyAlgorithmsType::toSelect();

        return Inertia::render('Admin/Template/AddLobbyFromGameLobbyTemplate', [
            'gameTemplate' => $gameTemplate,
            'assets' => $assets,
            'game' => $gameTemplate->game,
            'gameTypes' => $gameTypes,
            'gameAlgorithms' => $gameAlgorithms,
        ]);
    }

    public function storeLobby(StoreLobbyRequest $request, Game $game, GameLobbyStartSignalAction $gameLobbyStartSignal)
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

    public function create(Game $game)
    {
        $assets = Asset::get(['id', 'name']);
        $gameAlgorithms = GameLobbyAlgorithmsType::toSelect();

        return Inertia::render('Admin/Template/AddGameLobbyTemplate', [
            'game' => $game,
            'assets' => $assets,
            'gameAlgorithms' => $gameAlgorithms,
        ]);
    }

    public function store(StoreLobbyTemplateRequest $request, Game $game)
    {
        $game->gameTemplates()->create($request->validated());
        session()->flash('success', 'new lobby template got added successfully!');
        return redirect()->route('admin-gameTemplates.show', $game->id);
    }

    public function edit(GameLobbyTemplate $gameTemplate)
    {
        $assets = Asset::get(['id', 'name']);
        $gameAlgorithms = GameLobbyAlgorithmsType::toSelect();

        return Inertia::render('Admin/Template/EditGameLobbyTemplate', [
            'gameTemplate' => new GameLobbyTemplateResource($gameTemplate),
            'assets' => $assets,
            'gameAlgorithms' => $gameAlgorithms,
        ]);
    }

    public function update(UpdateLobbyTemplateRequest $request, GameLobbyTemplate $gameTemplate)
    {
        $gameTemplate->update($request->validated());
        session()->flash('success', 'lobby Template updated successfully!');
        return redirect()->route('admin-gameTemplates.show', $gameTemplate->game->id);
    }

    public function destroy(GameLobbyTemplate $gameTemplate)
    {
        $gameTemplate->delete();
        session()->flash('success', 'lobby deleted successfully!');
        return redirect()->route('admin-gameTemplates.show', $gameTemplate->game->id);
    }
}
