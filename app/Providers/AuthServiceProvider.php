<?php

namespace App\Providers;

use App\Models\ChatRoom;
use App\Models\GameLobby;
use App\Policies\ChatRoomPolicy;
use App\Policies\GameLobbyPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        GameLobby::class => GameLobbyPolicy::class,
        ChatRoom::class => ChatRoomPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
