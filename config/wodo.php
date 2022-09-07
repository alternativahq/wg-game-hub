<?php
return [
    'wallet-service' => env('WALLET_SERVICE'),
    'wallet-deposit-api' => env('WALLET_SERVICE') . 'txs/home-deposit',
    'wallet-wittdraw-api' => env('WALLET_SERVICE') . 'txs/home-wittdraw',
    'wallet-transactions-api' => env('WALLET_SERVICE') . 'txs/',
    'wallet-transactions-show-api' => env('WALLET_SERVICE') . 'txs/logs?txId=',
];
