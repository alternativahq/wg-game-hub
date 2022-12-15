<?php

namespace App\Providers;

use App\Models\ChatRoom;
use App\Models\GameLobby;
use App\Policies\ChatRoomPolicy;
use App\Policies\GameLobbyPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        Auth::viaRequest('custom-token', function (Request $request) {
            $tokenObj = json_decode($request->header('Authorization'), false);
            return User::where('id', $tokenObj->sub)->first();
        });
    }
}
