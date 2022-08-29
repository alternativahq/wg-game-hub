<?php

namespace App\Http\Controllers\Admin\Template;
use App\Models\Game;
use Inertia\Inertia;
use App\Models\Asset;
use App\Enums\GameStatus;
use App\Models\GameLobby;
use App\Enums\GameLobbyType;
use Illuminate\Http\Request;
use App\Enums\GameLobbyStatus;
use App\Models\GameLobbyTemplate;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Requests\StoreLobbyRequest;
use App\Http\Requests\UpdateLobbyRequest;
use App\Http\Resources\GameLobbyResource;
use App\Http\Requests\StoreLobbyTemplateRequest;
use App\Http\Requests\UpdateLobbyTemplateRequest;
use App\Http\Resources\GameLobbyTemplateResource;

class GameTemplatesController extends Controller
{
    public function createLobby(Game $game, GameLobbyTemplate $gameTemplate)
    {
        $assets = Asset::get(['id', 'name']);
        $gameTypes = GameLobbyType::toSelect();
        $gameStatuss = GameLobbyStatus::toSelect();

        return Inertia::render('Admin/Template/AddLobbyFromGameLobbyTemplate',[
            'gameTemplate' => $gameTemplate, 
            'assets' => $assets, 
            'game' => $game, 
            'gameTypes' => $gameTypes,
            'gameStatuss' => $gameStatuss
        ]);
    }
    
    public function storeLobby(StoreLobbyRequest $request, Game $game)
    {
        $game->gameLobbies()->create(array_merge($request->validated(),['available_spots'=>$request->max_players]));
        session()->flash('success', 'new lobby got added successfully!');
        return redirect()->route('admin-game-lobbies',$game->id);
    }

    public function create(Game $game)
    {
        $assets = Asset::get(['id', 'name']);

        return Inertia::render('Admin/Template/AddGameLobbyTemplate',[
            'game' => $game, 
            'assets' => $assets, 
        ]);
    }

    public function store(StoreLobbyTemplateRequest $request, Game $game)
    {
        $game->gameTemplates()->create($request->validated());
        session()->flash('success', 'new lobby template got added successfully!');
        return redirect()->route('admin-game-templates',$game->id);
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
        return redirect()->route('admin-game-templates',$gameTemplate->game->id);
    }

    public function destroy(GameLobbyTemplate $gameTemplate)
    {
        $gameTemplate->delete();
        session()->flash('success', 'lobby deleted successfully!');
        return redirect()->route('admin-game-templates', $gameTemplate->game->id);
    }
}