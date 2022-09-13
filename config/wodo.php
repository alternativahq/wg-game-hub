<?php
return [
    'api-authorization-token' => env('API_AUTHORIZATION_TOKEN'),
    'wallet-service' => env('WALLET_SERVICE'),
    'wallet-deposit-api' => env('WALLET_SERVICE') . 'txs/home-deposit',
    'wallet-withdraw-api' => env('WALLET_SERVICE') . 'txs/home-withdraw',
    'wallet-transactions-api' => env('WALLET_SERVICE') . 'txs/',
    'wallet-transactions-show-api' => env('WALLET_SERVICE') . 'txs/logs?txId=',
    'game-lobby-service-api' => env('GAME_LOBBY_SERVICE_API'),
];
