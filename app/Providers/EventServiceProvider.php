<?php

namespace App\Providers;

use App\Events\GameLobbyStartedEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Events\GameLobby\StateScheduledEvent;
use App\Events\GameLobby\AwaitingPlayersEvent;
use App\Events\GameLobby\GameLoobyCreatedEvent;
use App\Events\GameLobby\UserLeftGameLobbyEvent;
use App\Events\GameLobby\UserJoinedGameLobbyEvent;
use App\Events\GameLobby\UserRejoinedGameLobbyEvent;
use App\Listeners\GameLobby\User\UserLeftGameLobbyListener;
use App\Listeners\GameLobby\LifeCycle\StateScheduledListener;
use App\Listeners\GameLobby\User\UserJoinedGameLobbyListener;
use App\Listeners\GameLobby\LifeCycle\GameLobbyCreatedListener;
use App\Listeners\GameLobby\LifeCycle\GameLobbyStartedListener;
use App\Listeners\GameLobby\User\UserRejoinedGameLobbyListener;
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
        //life cycle
        GameLoobyCreatedEvent::class => [
            GameLobbyCreatedListener::class,
        ],
        StateScheduledEvent::class => [
            StateScheduledListener::class,
        ],
        AwaitingPlayersEvent::class => [
            AwaitingPlayersListener::class,
        ],
        GameLobbyStartedEvent::class => [
            GameLobbyStartedListener::class,
        ],
        //users
        UserJoinedGameLobbyEvent::class => [
            UserJoinedGameLobbyListener::class,
        ],
        UserLeftGameLobbyEvent::class => [
            UserLeftGameLobbyListener::class,
        ],
        UserRejoinedGameLobbyEvent::class => [
            UserRejoinedGameLobbyListener::class,
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
