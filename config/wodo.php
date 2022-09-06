<?php
return [
    'wallet-service' => env('WALLET_SERVICE'),
    'wallet-transactions-api' => env('WALLET_SERVICE') . 'txs/',
    'wallet-transactions-show-api' => env('WALLET_SERVICE') . 'txs/logs?txId=',
];
