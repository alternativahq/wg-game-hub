<?php

namespace App\Http\Controllers\Admin\Lobbies;

use DB;
use Event;
use Exception;
use Notification;
use App\Models\Asset;
use App\Models\ChatRoom;
use App\Models\GameLobby;
use App\Enums\ChatRoomType;
use App\Enums\GameLobbyType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Enums\GameLobbyStatus;
use App\Http\Controllers\Controller;
use App\Events\GameLobbyStartedEvent;
use App\Events\GameLobby\AwaitingPlayersEvent as GameLobbyAwaitingPlayersEvent;
use App\Events\GameLobby\DistributingPrizesEvent as GameLobbyDistributingPrizesEvent;
use App\Events\GameLobby\DistributedPrizesEvent as GameLobbyDistributedPrizesEvent;
use App\Events\GameLobby\GameEndedEvent;
use App\Events\GameLobby\GameArchivedEvent;
use App\Http\Resources\GameLobbyUserResource;
use App\Events\GameLobby\GameLobbyCreatedEvent;
use App\Events\GameLobby\ResultsProcessedEvent;
use App\DataTransferObjects\GameMatchResultData;
use App\Http\Requests\Admin\StoreGameLobbyRequest;
use App\Http\Requests\GameMatchResultsPayloadRequest;
use App\Notifications\GameLobbyDistributedPrizesNotification;
use App\Notifications\ProcessingGameLobbyResultsNotification;
use App\Notifications\GameLobbyDistributingPrizesNotification;
use App\Actions\Games\GameMatchResults\StoreGameMatchResultAction;

class GameLobbyController extends Controller
{
    public function store(StoreGameLobbyRequest $request)
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
            ])
            ->except('asset')
            ->toArray();

        try {
            DB::transaction(function () use ($payload) {
                $lobby = GameLobby::create($payload);
                event(new GameLobbyCreatedEvent($lobby, $payload));
                ChatRoom::create([
                    'id' => $lobby->id,
                    'type' => ChatRoomType::GameLobby,
                ]);
            });
        } catch (Exception $exception) {
            return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Something went wrong while creating game lobby.');
        }
        
        return response()->noContent();
    }

    public function toAwaitingPlayers(GameLobby $gameLobby)
    {
        abort_unless($gameLobby->state->is(GameLobbyStatus::Scheduled), Response::HTTP_FORBIDDEN);
        $gameLobby->update([
            'state' => GameLobbyStatus::AwaitingPlayers,
        ]);
        event(new GameLobbyAwaitingPlayersEvent($gameLobby));
        
        return response()->noContent();
    }

    public function inGame(Request $request, GameLobby $gameLobby)
    {
        abort_unless($gameLobby->state->is(GameLobbyStatus::AwaitingPlayers), Response::HTTP_FORBIDDEN);
        $request->validate([
            'url' => ['required', 'url'],
        ]);

        if (!$gameLobby->state->is(GameLobbyStatus::AwaitingPlayers)) {
            return abort(Response::HTTP_UNAUTHORIZED);
        }

        $gameLobby->state = GameLobbyStatus::InGame;

        if (!$gameLobby->save()) {
            return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Could not update game settings');
        }

        broadcast(new GameLobbyStartedEvent(gameLobby: $gameLobby, url: $request->url));

        return response()->noContent();
    }

    public function gameEnded(
        GameMatchResultsPayloadRequest $request,
        GameLobby $gameLobby,
        StoreGameMatchResultAction $storeGameMatchResultAction,
    ) {
        abort_unless($gameLobby->state->is(GameLobbyStatus::InGame), Response::HTTP_FORBIDDEN);
        $updated = $gameLobby->update([
            'state' => GameLobbyStatus::GameEnded,
        ]);

        // if ($updated) {
        //     broadcast(new ProcessingGameLobbyResultsNotification(gameLobby: $gameLobby));
        // }
        $gameMatchResultData = GameMatchResultData::fromRequest(request: $request);
        $storeGameMatchResultAction->execute(gameLobby: $gameLobby, gameMatchResultData: $gameMatchResultData);

        broadcast(new GameEndedEvent(gameLobby: $gameLobby));

        return response()->noContent();
    }

    public function distributingPrizes(GameLobby $gameLobby)
    {
        abort_unless($gameLobby->state->is(GameLobbyStatus::GameEnded), Response::HTTP_FORBIDDEN);
        $gameLobby->update([
            'state' => GameLobbyStatus::DistributingPrizes,
        ]);
        $gameLobby->load('users:id');
        Notification::send($gameLobby->users, new GameLobbyDistributingPrizesNotification(gameLobby: $gameLobby));
        event(new GameLobbyDistributingPrizesEvent($gameLobby));

        return response()->json();
    }

    public function distributedPrizes(GameLobby $gameLobby)
    {
        abort_unless($gameLobby->state->is(GameLobbyStatus::DistributingPrizes), Response::HTTP_FORBIDDEN);
        $gameLobby->update([
            'state' => GameLobbyStatus::DistributedPrizes,
        ]);
        $gameLobby->load('users:id');
        Notification::send($gameLobby->users, new GameLobbyDistributedPrizesNotification(gameLobby: $gameLobby));
        event(new GameLobbyDistributedPrizesEvent($gameLobby));

        return response()->json();
    }

    public function archived(GameLobby $gameLobby)
    {
        abort_unless($gameLobby->state->is(GameLobbyStatus::DistributedPrizes), Response::HTTP_FORBIDDEN);
        $gameLobby->update([
            'state' => GameLobbyStatus::Archived,
        ]);
        broadcast(new GameArchivedEvent(gameLobby: $gameLobby));
        return response()->json();
    }

    public function users(GameLobby $gameLobby)
    {
        $gameLobbyUsers = $gameLobby->users()->get();
        return GameLobbyUserResource::collection($gameLobbyUsers);
    }
}
