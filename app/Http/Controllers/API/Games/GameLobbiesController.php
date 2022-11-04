<?php

namespace App\Http\Controllers\API\Games;

use App\Models\Game;
use Inertia\Inertia;
use App\Models\Asset;
use App\Models\GameLobby;
use App\Enums\GameLobbyType;
use Illuminate\Http\Request;
use App\Models\GameLobbyUser;
use App\Enums\GameLobbyStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameLobbyResource;
use App\Http\Requests\ShowGameLobbyRequest;
use App\Http\Requests\Admin\UpdateGameLobbyRequest;
use App\Http\QueryPipelines\GameLobbyPipeline\GameLobbyPipeline;
use App\Http\QueryPipelines\AdminGameLobbiesPipeline\AdminGameLobbiesPipeline;

class GameLobbiesController extends Controller
{
    public function index(ShowGameLobbyRequest $request)
    {
        $gameLobbies = AdminGameLobbiesPipeline::make(
            builder: GameLobby::query(),
            request: $request,
        )
            ->with('asset:id,name,symbol')
            ->paginate();

        if($request->includeUsers){
            $gameLobbies->load('users:id,name,email,image,username');
        }
        if($request->includeGame){
            $gameLobbies->load('game:id,name,description');
        }
        return GameLobbyResource::collection($gameLobbies->withQueryString());
    }

    public function show(ShowGameLobbyRequest $request, GameLobby $gameLobby)
    {
        if($request->includeUsers){
            $gameLobby->load('users:id,name,email,image,username');
        }
        if($request->includeGame){
            $gameLobby->load('game:id,name,description');
        }

        $gameLobby->prize_pool = $gameLobby->calculateThePrize();
        return response()->json(new GameLobbyResource(resource: $gameLobby));
    }

    public function update(UpdateGameLobbyRequest $request, GameLobby $gameLobby)
    {
        $asset = Asset::where('symbol', $request->asset)->first();
        $lobbyType = GameLobbyType::fromGameLobbyServiceEnum($request->gameMode);
        $payload = collect($request->validated())
            ->except(
                'gameMode',
                'gameId',
                'themeColor',
                'baseEntranceFee',
                'minPlayers',
                'maxPlayers',
                'scheduledAt',
                'algorithmId',
                'startsAt',
                'gamePlayDuration',
                'gameStartDelayTime',
                'gameStartDelayLimit',
            )
            ->merge([
                'available_spots' => $request->maxPlayers,
                'state' => GameLobbyStatus::Scheduled,
                'asset_id' => $asset->id,
                'type' => $lobbyType->value,
                'game_id' => $request->gameId,
                'theme_color' => $request->themeColor,
                'base_entrance_fee' => $request->baseEntranceFee,
                'min_players' => $request->minPlayers,
                'max_players' => $request->maxPlayers,
                'scheduled_at' => $request->scheduledAt,
                'algorithm_id' => $request->algorithmId,
                'start_at' => $request->startsAt,
                'game_play_duration' => $request->gamePlayDuration,
                'game_start_delay_time' => $request->gameStartDelayTime,
                'game_start_delay_limit' => $request->gameStartDelayLimit,
            ])
            ->except('asset')
            ->toArray();

        $gameLobby->update($payload);
        return response()->noContent();
    }

    public function destroy(GameLobby $gameLobby)
    {
        $gameLobby->delete();
        return response()->noContent();
    }
}
