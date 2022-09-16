<?php

namespace App\Http\Controllers\API\Games;

use App\Actions\GameLobby\GameLobbyFinishedSignalAction;
use App\Actions\Games\GameMatchResults\StoreGameMatchResultAction;
use App\DataTransferObjects\GameMatchResultData;
use App\Enums\GameLobbyStatus;
use App\Events\GameLobby\ProcessingResultsEvent;
use App\Events\GameLobby\ResultsProcessedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\GameMatchResultsPayloadRequest;
use App\Models\GameLobby;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ResultsProcessedGameLobbyNotification;
use App\Notifications\ProcessingGameLobbyResultsNotification;

class GameLobbyResultsController extends Controller
{
    public function __construct(
        protected StoreGameMatchResultAction $storeGameMatchResultAction,
        protected GameLobbyFinishedSignalAction $gameLobbyFinishedSignal,
    ) {
    }

    public function __invoke(GameMatchResultsPayloadRequest $request, GameLobby $gameLobby)
    {
        $users = $gameLobby->users()->get();

        $gameLobby->state = GameLobbyStatus::GameEnded;
        Notification::sendNow($users, new ProcessingGameLobbyResultsNotification(gameLobby: $gameLobby));

        if ($gameLobby->save()) {
            broadcast(new ProcessingResultsEvent(gameLobby: $gameLobby));

            $gameMatchResultData = GameMatchResultData::fromRequest(request: $request);

            $this->storeGameMatchResultAction->execute(
                gameLobby: $gameLobby,
                gameMatchResultData: $gameMatchResultData,
            );

            $gameLobby->load('users');
            broadcast(
                new ResultsProcessedEvent(
                    gameLobby: $gameLobby->load([
                        'scores' => function ($q) {
                            return $q->orderBy('rank')->limit(5);
                        },
                    ]),
                ),
            );
            $this->gameLobbyFinishedSignal->execute(gameLobby: $gameLobby, gameMatchResultData: $gameMatchResultData);
            Notification::sendNow($users, new ResultsProcessedGameLobbyNotification(gameLobby: $gameLobby));
        }

        // Send transactions
        return response()->noContent();
    }
}
