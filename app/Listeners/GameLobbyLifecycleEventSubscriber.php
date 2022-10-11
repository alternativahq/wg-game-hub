<?php

namespace App\Listeners;

use App\Enums\GameLobbyLogType;
use App\Events\GameLobby\GameLobbyAwaitingPlayersEvent as GameLobbyAwaitingPlayersEvent;
use App\Events\GameLobby\GameLobbyDistributedPrizesEvent;
use App\Events\GameLobby\GameLobbyDistributingPrizesEvent;
use App\Events\GameLobby\GameLobbyArchivedEvent;
use App\Events\GameLobby\GameLobbyEndedEvent;
use App\Events\GameLobby\GameLobbyAbortedEvent;
use App\Events\GameLobby\GameLobbyCreatedEvent;
use App\Events\GameLobby\GameLobbyStartTimeChangedEvent;
use App\Events\GameLobby\GameLobbyStartVotingPassedEvent;
use App\Events\GameLobby\GameLobbyStartVotingFailedEvent;
use App\Events\GameLobby\GameLobbyUserJoinedGameLobbyEvent;
use App\Events\GameLobby\GameLobbyUserLeftGameLobbyEvent;
use App\Events\GameLobbyStartedEvent;

class GameLobbyLifecycleEventSubscriber
{
    public function handleCreated(GameLobbyCreatedEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyCreated,
            'description' => 'A new game lobby is created',
            'payload' => json_encode($event->payload),
        ]);

        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyStateScheduled,
            'description' => 'Game lobby scheduled',
            'payload' => json_encode($event->payload),
        ]);
    }

    public function handleAwaitingPlayers(GameLobbyAwaitingPlayersEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyStateAwaitingPlayers,
            'description' => 'Game lobby is in awaiting players state',
        ]);
    }

    public function handleInGame(GameLobbyStartedEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyStateInGame,
            'description' => 'Game lobby is in game state',
            'payload' => json_encode(['url' => $event->url], true),
        ]);
    }

    public function handleGameEnded(GameLobbyEndedEvent $gameEndedEvent): void
    {
        $gameEndedEvent->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyStateEnded,
            'description' => 'Game lobby is ended',
            'payload' => $gameEndedEvent->matchResults,
        ]);
    }

    public function handleDistributingPrizes(GameLobbyDistributingPrizesEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyDistributingPrizes,
            'description' => 'Game lobby started distributing prizes',
        ]);
    }

    public function handleDistributedPrizes(GameLobbyDistributedPrizesEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyDistributedPrizes,
            'description' => 'Game lobby finished distributing prizes',
        ]);
    }

    public function handleArchived(GameLobbyArchivedEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::GameLobbyArchived,
            'description' => 'Game lobby has been archived',
        ]);
    }

    public function handleUserJoined(GameLobbyUserJoinedGameLobbyEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::UserJoined,
            'description' =>
                'User username: ' .
                $event->user->username .
                ' with and id of ' .
                $event->user->id .
                ' joined the game lobby.',
            'payload' => json_encode([
                'user' => $event->user,
                'entranceFee' => $event->entranceFee,
            ]),
        ]);
    }

    public function handleUserLeft(GameLobbyUserLeftGameLobbyEvent $event): void
    {
        $event->gameLobby->activityLogs()->create([
            'name' => GameLobbyLogType::UserLeft,
            'description' =>
                'User username: ' .
                $event->user->username .
                ' with and id of ' .
                $event->user->id .
                ' left the game lobby.',
            'payload' => json_encode([
                'user' => $event->user,
            ]),
        ]);
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

    public function handleAborted($event): void
    {
    }

    public function subscribe($event): array
    {
        return [
            GameLobbyCreatedEvent::class => 'handleCreated',
            GameLobbyAwaitingPlayersEvent::class => 'handleAwaitingPlayers',
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
            GameLobbyAbortedEvent::class => 'handleAborted',
        ];
    }
}
