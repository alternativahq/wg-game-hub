<?php

namespace App\Http\Middleware;

use App\Enums\GameLobbyStatus;
use App\Enums\UserAssetAccountStatus;
use App\Http\Resources\GameLobbyResource;
use App\Models\GameLobby;
use Cache;
use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Actions\Wallet\GetUserAssetAccountsAction;

class HandleInertiaRequests extends Middleware
{
    public function __construct(public GetUserAssetAccountsAction $getUserAssetAccountAction)
    {
        // parent::__construct;
    }
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    protected function loadUserData(Request $request)
    {
        return [
            'id' => $request->user()->id,
            'name' => $request->user()->name,
            'username' => $request->user()->username,
            'last_name' => $request->user()->last_name,
            'full_name' => $request->user()->full_name,
            'unread_notifications' => $request
                ->user()
                ->unreadNotifications()
                ->take(10)
                ->get(),
            'email' => $request->user()->email,
            'is_admin' => $request->user()->is_admin,
            'image' => $request->user()->image,
            'image_url' => $request->user()->image_url,
            'asset_accounts' => $this->getUserAssetAccountAction->execute(),
            'cooldown_end_at' => function () use ($request) {
                $user = $request->user();
                if (!$user->is_in_cooldown_period && !is_null($user->cooldown_end_at)) {
                    $user->update([
                        'cooldown_end_at' => null,
                    ]);
                    return null;
                }
                return $user->cooldown_end_at;
            },
            'current_lobby_session' => Cache::remember(
                key: 'user.' . $request->user()->id . '.current-lobby-session',
                ttl: 1,
                callback: function () use ($request) {
                    $session = $request
                        ->user()
                        ->gameLobbies()
                        ->whereIn('state', [
                            GameLobbyStatus::Scheduled,
                            GameLobbyStatus::InGame,
                            GameLobbyStatus::AwaitingPlayers,
                        ])
                        ->first();

                    return $session
                        ? GameLobbyResource::make(new GameLobby($session->only('id', 'game_id', 'name')))
                        : null;
                },
            ),
        ];
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'current_url' => url()->current(),
            'app_url' => config('app.url'),
            'auth' => function () use ($request) {
                return [
                    'user' => $request->user() ? $this->loadUserData(request: $request) : null,
                ];
            },
            'config' => [
                'dashboard_art' => asset('images/dashboard-art.png'),
                'main_pattern' => asset('images/main-pattern.png'),
                'game_lobby_pattern' => asset('images/game-lobby-pattern.png'),
                'game_lobby_loading_gif' => asset('images/game-lobby-loading.gif'),
            ],
            'flash' => function () use ($request) {
                return [
                    'error' => session()->get('error'),
                    'success' => session()->get('success'),
                ];
            },
        ]);
    }
}
