<?php

namespace App\Listeners;

use App\Enums\GameLobbyLogType;
use App\Events\GameLobbyStartedEvent;
use App\Events\GameLobby\GameLobbyEndedEvent;
use App\Events\GameLobby\GameLobbyAbortedEvent;
use App\Events\GameLobby\GameLobbyCreatedEvent;
use App\Events\GameLobby\GameLobbyLatestUpdate;
use App\Events\GameLobby\GameLobbyArchivedEvent;
use App\Events\GameLobby\GameLobbyAbortedRefundingEvent;
use App\Events\GameLobby\GameLobbyGameStartDelayedEvent;
use App\Events\GameLobby\GameLobbyStartTimeChangedEvent;
use App\Events\GameLobby\GameLobbyDistributedPrizesEvent;
use App\Events\GameLobby\GameLobbyStartVotingFailedEvent;
use App\Events\GameLobby\GameLobbyStartVotingPassedEvent;
use App\Events\GameLobby\GameLobbyUserLeftGameLobbyEvent;
use App\Events\GameLobby\GameLobbyDistributingPrizesEvent;
use App\Events\GameLobby\GameLobbyUserJoinedGameLobbyEvent;
use App\Events\GameLobby\GameLobbyAwaitingPlayersEvent as GameLobbyAwaitingPlayersEvent;

class GameLobbyLifecycleEventSubscriber
{
    public function handleCreated(GameLobbyCreatedEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyCreated,
            'description' => 'A new game lobby is created',
            'payload' => json_encode($event->payload),
            'created_at'=> $now = now(),
            'updated_at'=> $now,
        ]);
        $event->gameLobby->update([
        'latest_update' => $event->gameLobby->name . ' lobby is created',
        ]);

        event(new GameLobbyLatestUpdate(gameLobby: $event->gameLobby));

        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyStateScheduled,
            'description' => 'Game lobby scheduled',
            'payload' => json_encode($event->payload),
            'created_at'=> $then = $now->addSecond(),
            'updated_at'=> $then,
        ]);

        $event->gameLobby->update([
            'latest_update' => $event->gameLobby . ' lobby scheduled',
        ]);

        event(new GameLobbyLatestUpdate(gameLobby: $event->gameLobby));
    }

    public function handleAwaitingPlayers(GameLobbyAwaitingPlayersEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyStateAwaitingPlayers,
            'description' => 'Game lobby is in awaiting players state',
        ]);

        $event->gameLobby->update([
            'latest_update' => 'Game lobby is in awaiting players state',
        ]);

        event(new GameLobbyLatestUpdate(gameLobby: $event->gameLobby));
    }

    public function handleGameStartDelayed(GameLobbyGameStartDelayedEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyGameStartDelayed,
            'description' => 'Game lobby has been delayed by '. $event->gameLobby->game_start_delay_time . ' sec',
        ]);

        $event->gameLobby->update([
            'latest_update' => 'Game lobby has been delayed by '. $event->gameLobby->game_start_delay_time . ' sec',
        ]);

        event(new GameLobbyLatestUpdate(gameLobby: $event->gameLobby));
    }

    public function handleAbortedRefunding(GameLobbyAbortedRefundingEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyStateAbortedRefunding,
            'description' => 'Game lobby got aborted due to '. $event->cause .' and started refunding the players',
        ]);

        $event->gameLobby->update([
            'latest_update' => 'Game lobby got aborted due to '. $event->cause .' and started refunding the players',
        ]);

        event(new GameLobbyLatestUpdate(gameLobby: $event->gameLobby));
    }

    public function handleAborted(GameLobbyAbortedEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyStateAborted,
            'description' => 'Game lobby got aborted',
        ]);

        $event->gameLobby->update([
            'latest_update' => 'Game lobby got aborted',
        ]);

        event(new GameLobbyLatestUpdate(gameLobby: $event->gameLobby));
    }

    public function handleInGame(GameLobbyStartedEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyStateInGame,
            'description' => 'Game lobby is in game state',
            'payload' => json_encode(['url' => $event->url], true),
        ]);

        $event->gameLobby->update([
            'latest_update' => 'The game has started',
        ]);

        event(new GameLobbyLatestUpdate(gameLobby: $event->gameLobby));
    }

    public function handleGameEnded(GameLobbyEndedEvent $gameEndedEvent): void
    {
        $gameEndedEvent->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyStateEnded,
            'description' => 'Game lobby is ended',
            'payload' => $gameEndedEvent->matchResults,
        ]);

        $gameEndedEvent->gameLobby->update([
            'latest_update' => 'The game has ended',
        ]);
        event(new GameLobbyLatestUpdate(gameLobby: $gameEndedEvent->gameLobby));
    }

    public function handleDistributingPrizes(GameLobbyDistributingPrizesEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyDistributingPrizes,
            'description' => 'Game lobby started distributing prizes',
        ]);

        $event->gameLobby->update([
            'latest_update' => 'Game lobby started distributing prizes',
        ]);

        event(new GameLobbyLatestUpdate(gameLobby: $event->gameLobby));
    }

    public function handleDistributedPrizes(GameLobbyDistributedPrizesEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyDistributedPrizes,
            'description' => 'Game lobby finished distributing prizes',
        ]);

        $event->gameLobby->update([
            'latest_update' => 'Game lobby finished distributing prizes',
        ]);

        event(new GameLobbyLatestUpdate(gameLobby: $event->gameLobby));
    }

    public function handleArchived(GameLobbyArchivedEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyArchived,
            'description' => 'Game lobby has been archived',
        ]);

        $event->gameLobby->update([
            'latest_update' => 'Game lobby has been archived',
        ]);

        event(new GameLobbyLatestUpdate(gameLobby: $event->gameLobby));
    }

    public function handleUserJoined(GameLobbyUserJoinedGameLobbyEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::UserJoined,
            'description' =>
                'User username: ' .
                $event->user->username .
                ' with an id of ' .
                $event->user->id .
                ' joined the game lobby.',
            'payload' => json_encode([
                'user' => $event->user,
                'entranceFee' => $event->entranceFee,
            ]),
        ]);

        $event->gameLobby->update([
            'latest_update' => $event->user->username . ' has joined the game lobby.',
        ]);

        event(new GameLobbyLatestUpdate(gameLobby: $event->gameLobby));
    }

    public function handleUserLeft(GameLobbyUserLeftGameLobbyEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::UserLeft,
            'description' =>
                'User username: ' .
                $event->user->username .
                ' with an id of ' .
                $event->user->id .
                ' left the game lobby.',
            'payload' => json_encode([
                'user' => $event->user,
            ]),
        ]);

        $event->gameLobby->update([
            'latest_update' => $event->user->username . ' has left the game lobby.',
        ]);

        event(new GameLobbyLatestUpdate(gameLobby: $event->gameLobby));
    }

    public function handleStartTimeChanged($event): void
    {
    }

    public function handleStartVotingPassed($event): void
    {
    }

    public function handleStartVotingFailed($event): void
    {
    }

    public function subscribe($event): array
    {
        return [
            GameLobbyCreatedEvent::class => 'handleCreated',
            GameLobbyAwaitingPlayersEvent::class => 'handleAwaitingPlayers',
            GameLobbyGameStartDelayedEvent::class => 'handleGameStartDelayed',
            GameLobbyAbortedRefundingEvent::class => 'handleAbortedRefunding',
            GameLobbyAbortedEvent::class => 'handleAborted',
            GameLobbyStartedEvent::class => 'handleInGame',
            GameLobbyEndedEvent::class => 'handleGameEnded',
            GameLobbyDistributingPrizesEvent::class => 'handleDistributingPrizes',
            GameLobbyDistributedPrizesEvent::class => 'handleDistributedPrizes',
            GameLobbyArchivedEvent::class => 'handleArchived',
            GameLobbyUserJoinedGameLobbyEvent::class => 'handleUserJoined',
            GameLobbyUserLeftGameLobbyEvent::class => 'handleUserLeft',
            GameLobbyStartVotingPassedEvent::class => 'handleStartVotingPassed',
            GameLobbyStartVotingFailedEvent::class => 'handleStartVotingFailed',
            GameLobbyStartTimeChangedEvent::class => 'handleStartTimeChanged',
        ];
    }
}
