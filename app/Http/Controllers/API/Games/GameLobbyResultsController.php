<?php

namespace App\Http\Controllers\API\Games;

use App\Actions\Games\GameMatchResults\StoreGameMatchResultAction;
use App\DataTransferObjects\GameMatchResultData;
use App\Enums\GameLobbyStatus;
use App\Events\GameLobby\ProcessingResultsEvent;
use App\Events\GameLobby\ResultsProcessedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\GameMatchResultsPayloadRequest;
use App\Models\GameLobby;
use App\Enums\NotificationType;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ResultsProcessedGameLobbyNotification;
use App\Notifications\ResultsProcessingGameLobbyNotification;

class GameLobbyResultsController extends Controller
{
    public function __construct(
        public StoreGameMatchResultAction $storeGameMatchResultAction,
    ) {
    }

    public function __invoke(
        GameMatchResultsPayloadRequest $request,
         GameLobby $gameLobby,
         ) {
        $users = $gameLobby->users()->get(['id']);
        Notification::send($users, new ResultsProcessingGameLobbyNotification());

        $gameLobby->status = GameLobbyStatus::ProcessingResults;
        $gameLobby->save();

        broadcast(new ProcessingResultsEvent(gameLobby: $gameLobby));

        $gameMatchResultData = GameMatchResultData::fromRequest(
            request: $request,
        );

        $this->storeGameMatchResultAction->execute(
            gameLobby: $gameLobby,
             gameMatchResultData: $gameMatchResultData,
            );

        broadcast(
            new ResultsProcessedEvent(
                gameLobby: $gameLobby->fresh(['users', 'scores']),
            ),
        );

       
        Notification::send($users, new ResultsProcessedGameLobbyNotification());

        return response()->noContent();
    }
}
