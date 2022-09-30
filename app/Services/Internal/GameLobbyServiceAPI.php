<?php

namespace App\Services\Internal;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class GameLobbyServiceAPI
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('wodo.game-lobby-service-base-url');
    }

    public function startLifecycle(array $data): Response
    {
        $url = $this->baseUrl . '/lifecycle';

        return Http::retry(5, 1000)->post($url, $data);
    }
}
