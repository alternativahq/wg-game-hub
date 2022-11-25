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
use App\Enums\GameLobbyAbourtCause;
use App\Http\Controllers\Controller;
use App\Events\GameLobbyStartedEvent;
use App\Http\Requests\GenericRequestApi;
use App\Events\GameLobby\GameLobbyEndedEvent;
use App\Http\Resources\GameLobbyUserResource;
use App\Events\GameLobby\GameLobbyAbortedEvent;
use App\Events\GameLobby\GameLobbyCreatedEvent;
use App\DataTransferObjects\GameMatchResultData;
use App\Events\GameLobby\GameLobbyArchivedEvent;
use App\Http\Requests\GameLobbyAbortedRefunding;
use App\Http\Requests\Admin\StoreGameLobbyRequest;
use App\Http\Requests\GameMatchResultsPayloadRequest;
use App\Events\GameLobby\GameLobbyAbortedRefundingEvent;
use App\Events\GameLobby\GameLobbyGameStartDelayedEvent;
use App\Events\GameLobby\GameLobbyProcessedGameResultsEvent;
use App\Events\GameLobby\GameLobbyProcessingGameResultsEvent;
use App\Notifications\GameLobbyDistributedPrizesNotification;
use App\Notifications\ProcessingGameLobbyResultsNotification;
use App\Notifications\GameLobbyDistributingPrizesNotification;
use App\Actions\Games\GameMatchResults\StoreGameMatchResultAction;
use App\Events\GameLobby\GameLobbyAwaitingPlayersEvent as GameLobbyAwaitingPlayersEvent;
use App\Events\GameLobby\GameLobbyDistributedPrizesEvent as GameLobbyDistributedPrizesEvent;
use App\Events\GameLobby\GameLobbyDistributingPrizesEvent as GameLobbyDistributingPrizesEvent;

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
                'sessionId',
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
                'session_id' => $request->sessionId,
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

    public function gameStartDelayed(GameLobby $gameLobby)
    {
        abort_unless($gameLobby->state->is(GameLobbyStatus::AwaitingPlayers) && $gameLobby->game_start_delay_limit != null, Response::HTTP_FORBIDDEN);
        if($gameLobby->game_start_delay_count < $gameLobby->game_start_delay_limit){
            $gameLobby->update([
                'start_at' => $gameLobby->start_at->addSecond($gameLobby->game_start_delay_time),
                'game_start_delay_count' => $gameLobby->game_start_delay_count +1,
            ]);
            event(new GameLobbyGameStartDelayedEvent($gameLobby));
            return response()->noContent();
        }
        return response()->json('you can not delay more than '. $gameLobby->game_start_delay_limit . ' times');
    }

    public function gameLobbyAbortedRefunding(Request $request, GameLobby $gameLobby)
    {
        $request->validate([
            'cause' => ['required', 'in:' . collect(array_column(GameLobbyAbourtCause::cases(), 'value'))->implode(',')],
        ]);
        abort_unless($gameLobby->state->is(GameLobbyStatus::AwaitingPlayers), Response::HTTP_FORBIDDEN);
        $gameLobby->update([
            'state' => GameLobbyStatus::GameLobbyAbortedRefunding,
        ]);
        event(new GameLobbyAbortedRefundingEvent($gameLobby, $request->cause));

        return response()->noContent();
    }

    public function gameLobbyAborted(GameLobby $gameLobby)
    {
        abort_unless($gameLobby->state->is(GameLobbyStatus::GameLobbyAbortedRefunding), Response::HTTP_FORBIDDEN);
        $gameLobby->update([
            'state' => GameLobbyStatus::GameLobbyAborted,
        ]);
        event(new GameLobbyAbortedEvent($gameLobby));

        return response()->noContent();
    }

    public function inGame(Request $request, GameLobby $gameLobby)
    {
        $request->validate([
            'url' => ['required', 'url'],
            'sessionId' => ['required'],
        ]);
        abort_unless($gameLobby->state->is(GameLobbyStatus::AwaitingPlayers), Response::HTTP_FORBIDDEN);

        $gameLobby->state = GameLobbyStatus::InGame;
        $gameLobby->url = $request->url;
        $gameLobby->session_id = $request->sessionId;

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
            'state' => GameLobbyStatus::ProcessedGameResults,
        ]);

        $gameMatchResultData = GameMatchResultData::fromRequest(request: $request);
        $storeGameMatchResultAction->execute(gameLobby: $gameLobby, gameMatchResultData: $gameMatchResultData);

        event(new GameLobbyEndedEvent(gameLobby: $gameLobby, matchResults: $request->validated()));

        return response()->noContent();
    }

    public function processingGameResults(GameLobby $gameLobby) {
        abort_unless($gameLobby->state->is(GameLobbyStatus::GameEnded), Response::HTTP_FORBIDDEN);
        $updated = $gameLobby->update([
            'state' => GameLobbyStatus::ProcessingGameResults,
        ]);

        event(new GameLobbyProcessingGameResultsEvent(gameLobby: $gameLobby));

        return response()->noContent();
    }

    public function processedGameResults(GameLobby $gameLobby) {
        abort_unless($gameLobby->state->is(GameLobbyStatus::ProcessingGameResults), Response::HTTP_FORBIDDEN);

        $updated = $gameLobby->update([
            'state' => GameLobbyStatus::ProcessedGameResults,
        ]);

        event(new GameLobbyProcessedGameResultsEvent(gameLobby: $gameLobby));

        return response()->noContent();
    }

    public function distributingPrizes(GameLobby $gameLobby)
    {
        abort_unless($gameLobby->state->is(GameLobbyStatus::ProcessedGameResults), Response::HTTP_FORBIDDEN);
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
        broadcast(new GameLobbyArchivedEvent(gameLobby: $gameLobby));
        return response()->json();
    }

    public function genericApi(GenericRequestApi $request,GameLobby $gameLobby, $state)
    {
        return match ($state) {
            '20' => $this->toAwaitingPlayers($gameLobby),
            '30' => $this->inGame($request, $gameLobby),
            '40' => "you cant add change to this state",
            '50' => $this->processingGameResults($gameLobby),
            '60' => $this->processedGameResults($gameLobby),
            '70' => $this->distributingPrizes($gameLobby),
            '80' => $this->distributedPrizes($gameLobby),
            '90' => $this->gameLobbyAbortedRefunding($request, $gameLobby),
            '100' => $this->gameLobbyAborted($gameLobby),
            '110' => $this->archived($gameLobby),
            default => 'bad entrie',
        };
    }

    public function users(GameLobby $gameLobby)
    {
        $gameLobbyUsers = $gameLobby->users()->get();
        return GameLobbyUserResource::collection($gameLobbyUsers);
    }
}
