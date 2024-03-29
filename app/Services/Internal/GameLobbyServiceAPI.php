<?php

namespace App\Services\Internal;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class GameLobbyServiceAPI
{
    protected string $baseUrl;
    protected string $tokenBaseUrl;

    public function __construct()
    {
        $this->baseUrl = config('wodo.game-lobby-service-base-url');
        $this->tokenBaseUrl = config('wodo.game-lobby-token-service-base-url');
    }

    public function startLifecycle(array $data): Response
    {
        $url = $this->baseUrl . '/lifecycle';

        return Http::retry(5, 1000)->post($url, $data);
    }

    public function getToken($gameLobby_id, $user_id): Response
    {
        $url = $this->tokenBaseUrl . '/game-tokens/' . $user_id . '/' . $gameLobby_id;

        return Http::get($url);
    }
}
