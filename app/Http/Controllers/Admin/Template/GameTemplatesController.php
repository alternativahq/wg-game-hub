<?php

namespace App\Http\Controllers\Admin\Template;
use App\Actions\GameLobby\GameLobbyStartSignalAction;
use App\Models\Game;
use Inertia\Inertia;
use App\Models\Asset;
use App\Enums\GameStatus;
use App\Models\GameLobby;
use App\Enums\GameLobbyType;
use App\Enums\GameLobbyStatus;
use App\Models\GameLobbyTemplate;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLobbyRequest;
use App\Http\Requests\StoreLobbyTemplateRequest;
use App\Http\Requests\UpdateLobbyTemplateRequest;
use App\Http\Resources\GameLobbyTemplateResource;

class GameTemplatesController extends Controller
{
    public function createLobby(GameLobbyTemplate $gameTemplate)
    {
        $assets = Asset::get(['id', 'name']);
        $gameTypes = GameLobbyType::toSelect();
        $gameStatuss = GameLobbyStatus::toSelect();

        return Inertia::render('Admin/Template/AddLobbyFromGameLobbyTemplate', [
            'gameTemplate' => $gameTemplate,
            'assets' => $assets,
            'game' => $gameTemplate->game,
            'gameTypes' => $gameTypes,
        ]);
    }

    public function storeLobby(StoreLobbyRequest $request, Game $game, GameLobbyStartSignalAction $gameLobbyStartSignal)
    {
        $gameLobby = $game->gameLobbies()->create(
            array_merge($request->validated(), [
                'available_spots' => $request->max_players,
                'status' => GameLobbyStatus::Scheduled,
            ]),
        );

        $gameLobby->load('asset');
        $gameLobbyStartSignal->execute(gameLobby: $gameLobby);

        session()->flash('success', 'new lobby got added successfully!');
        return redirect()->route('admin-gameLobbies.show', $game->id);
    }

    public function create(Game $game)
    {
        $assets = Asset::get(['id', 'name']);

        return Inertia::render('Admin/Template/AddGameLobbyTemplate', [
            'game' => $game,
            'assets' => $assets,
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

        return Inertia::render('Admin/Template/EditGameLobbyTemplate', [
            'gameTemplate' => new GameLobbyTemplateResource($gameTemplate),
            'assets' => $assets,
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
