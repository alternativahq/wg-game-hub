<?php

namespace App\Providers;

use App\Events\{
    GameLobby\GameLobbyStartimeChanged,
    GameLobby\GameLobbyAborted,
    //Voting
    GameLobby\Voting\GameLobbyStartVotingPassed,
    GameLobby\Voting\GameLobbyStartVotingFailed,
    //LifeCycle
    GameLobby\GameLobbyCreatedEvent,
    GameLobby\StateScheduledEvent as GameLobbyStateScheduledEvent,
    GameLobby\AwaitingPlayersEvent as GameLobbyAwaitingPlayersEvent,
    GameLobbyStartedEvent,
    GameLobby\GameEndedEvent as GameLobbyGameEndedEvent,
    GameLobby\DistributingPrizesEvent as GameLobbyDistributingPrizesEvent,
    GameLobby\DistributedPrizesEvent as GameLobbyDistributedPrizesEvent,
    GameLobby\GameArchivedEvent as GameLobbyArchivedEvent,
    //user
    GameLobby\UserLeftGameLobbyEvent,
    GameLobby\UserJoinedGameLobbyEvent,
    GameLobby\UserRejoinedGameLobbyEvent,
};
use App\Listeners\{
    GameLobby\StoreGameLobbyStartimeChangedActivityLogListener,
    GameLobby\StoreGameLobbyAbortedActivityLogListener,
    //Voting
    GameLobby\Voting\StoreGameLobbyStartVotingPassedActivityLogListener,
    GameLobby\Voting\StoreGameLobbyStartVotingFailedActivityLogListener,
    //LifeCycle
    GameLobby\LifeCycle\StoreGameLobbyCreatedActivityLogListener,
    GameLobby\LifeCycle\StoreGameLobbyStateScheduledActivityLogListener,
    GameLobby\LifeCycle\StoreAwaitingPlayersActivityLogListener,
    GameLobby\LifeCycle\StoreGameLobbyStartedActivityLogListener,
    GameLobby\LifeCycle\StoreGameLobbyGameEndedActivityLogListener,
    GameLobby\LifeCycle\StoreGameLobbyDistributingPrizesActivityLogListener,
    GameLobby\LifeCycle\StoreGameLobbyDistributedPrizesActivityLogListener,
    GameLobby\LifeCycle\StoreGameLobbyArchivedActivityLogListener,
    //user
    GameLobby\User\StoreUserJoinedGameLobbyActivityLogListener,
    GameLobby\User\StoreUserLeftGameLobbyActivityLogListener,
    GameLobby\User\StoreUserRejoinedGameLobbyActivityLogListener,
};
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        //gameLobby
        GameLobbyStartimeChanged::class => [
            StoreGameLobbyStartimeChangedActivityLogListener::class,
        ],
        GameLobbyAborted::class => [
            StoreGameLobbyAbortedActivityLogListener::class,
        ],
        //voting
        GameLobbyStartVotingPassed::class => [
            StoreGameLobbyStartVotingPassedActivityLogListener::class,
        ],
        GameLobbyStartVotingFailed::class => [
            StoreGameLobbyStartVotingFailedActivityLogListener::class,
        ],
        //life cycle
        GameLobbyCreatedEvent::class => [
            StoreGameLobbyCreatedActivityLogListener::class,
        ],
        //no function to but the event
        GameLobbyStateScheduledEvent::class => [
            StoreGameLobbyStateScheduledActivityLogListener::class,
        ],
        GameLobbyAwaitingPlayersEvent::class => [
            StoreAwaitingPlayersActivityLogListener::class,
        ],
        GameLobbyStartedEvent::class => [
            StoreGameLobbyStartedActivityLogListener::class,
        ],
        GameLobbyGameEndedEvent::class => [
            StoreGameLobbyGameEndedActivityLogListener::class,
        ],
        GameLobbyDistributingPrizesEvent::class => [
            StoreGameLobbyDistributingPrizesActivityLogListener::class,
        ],
        GameLobbyDistributedPrizesEvent::class => [
            StoreGameLobbyDistributedPrizesActivityLogListener::class,
        ],
        GameLobbyArchivedEvent::class => [
            StoreGameLobbyArchivedActivityLogListener::class,
        ],
        //users
        UserJoinedGameLobbyEvent::class => [
            StoreUserJoinedGameLobbyActivityLogListener::class,
        ],
        UserLeftGameLobbyEvent::class => [
            StoreUserLeftGameLobbyActivityLogListener::class,
        ],
        //no function to but the event
        UserRejoinedGameLobbyEvent::class => [
            StoreUserRejoinedGameLobbyActivityLogListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
