<?php

namespace App\Http\Controllers\API\Games;

use App\Actions\Games\GameLobbies\DistributePrizesAction;
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
use App\Notifications\ProcessingGameLobbyResultsNotification;

class GameLobbyResultsController extends Controller
{
    public function __construct(
        protected StoreGameMatchResultAction $storeGameMatchResultAction,
        protected DistributePrizesAction $distributePrizesAction,
    ) {
    }

    public function __invoke(GameMatchResultsPayloadRequest $request, GameLobby $gameLobby)
    {
        $users = $gameLobby->users()->get();

        Notification::sendNow($users, new ProcessingGameLobbyResultsNotification(gameLobby: $gameLobby));

        $gameLobby->status = GameLobbyStatus::ProcessingResults;
        if ($gameLobby->save()) {
            broadcast(new ProcessingResultsEvent(gameLobby: $gameLobby));

            $gameMatchResultData = GameMatchResultData::fromRequest(request: $request);

            $this->storeGameMatchResultAction->execute(
                gameLobby: $gameLobby,
                gameMatchResultData: $gameMatchResultData,
            );
            
            //the data passed is suposed to be 5 but in the front received 12 and the second problem is that there is no user id because this is api
            $gameLobby->load('users');
            broadcast(new ResultsProcessedEvent(
                gameLobby: $gameLobby->load(['scores'=> function($q){
                    return $q->orderBy('rank')->limit(5);
                }]),
            ));

            Notification::sendNow($users, new ResultsProcessedGameLobbyNotification(gameLobby: $gameLobby));

            // $this->distributePrizesAction->execute(gameLobby: $gameLobby, gameMatchResultData: $gameMatchResultData);
        }

        // Send transactions
        return response()->noContent();
    }
}
