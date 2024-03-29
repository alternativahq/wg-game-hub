<?php

use App\Http\Controllers\API\{
    ChatRooms\ChatRoomMessageController,
    Games\GameLobbiesController,
    Games\GameLobbyCurrenUserController,
    Games\GameLobbyJoinController,
    Games\GameLobbyLeaveController,
    Games\GamesController,
    Wallet\TransactionShowController as UserTransactionShowController,
    Notifications\DeleteNotificationsController,
    Notifications\MarkNotificationAsReadController,
    Notifications\NotificationController,
    Notifications\SendNotificationController,
};
use Illuminate\Support\Facades\Route;

// Machine to Machine
// aws-auth or api.basic-auth comes from kernal.php
// auth:api it will work
Route::middleware('api.basic-auth')->group(function () {
    Route::post('notifications', SendNotificationController::class)->name('notifications.send');

    Route::post('game-lobbies', [\App\Http\Controllers\Admin\Lobbies\GameLobbyController::class, 'store']);

    Route::put('game-lobbies/{gameLobby}/awaiting-players', [
        \App\Http\Controllers\Admin\Lobbies\GameLobbyController::class,
        'toAwaitingPlayers',
    ]);

    Route::put('game-lobbies/{gameLobby}/game-start-delayed', [
        \App\Http\Controllers\Admin\Lobbies\GameLobbyController::class,
        'gameStartDelayed',
    ]);
    Route::put('game-lobbies/{gameLobby}/aborted-refunding', [
        \App\Http\Controllers\Admin\Lobbies\GameLobbyController::class,
        'gameLobbyAbortedRefunding',
    ]);
    Route::put('game-lobbies/{gameLobby}/aborted', [
        \App\Http\Controllers\Admin\Lobbies\GameLobbyController::class,
        'gameLobbyAborted',
    ]);
    Route::put('game-lobbies/{gameLobby}/in-game', [
        \App\Http\Controllers\Admin\Lobbies\GameLobbyController::class,
        'inGame',
    ])->name('games.game-lobbies.start');

    Route::put('game-lobbies/{gameLobby}/game-ended', [
        \App\Http\Controllers\Admin\Lobbies\GameLobbyController::class,
        'gameEnded',
    ]);

    Route::put('game-lobbies/{gameLobby}/processing-game-results', [
        \App\Http\Controllers\Admin\Lobbies\GameLobbyController::class,
        'processingGameResults',
    ]);

    Route::put('game-lobbies/{gameLobby}/processed-game-results', [
        \App\Http\Controllers\Admin\Lobbies\GameLobbyController::class,
        'processedGameResults',
    ]);

    Route::put('game-lobbies/{gameLobby}/distributing-prizes', [
        \App\Http\Controllers\Admin\Lobbies\GameLobbyController::class,
        'distributingPrizes',
    ]);

    Route::put('game-lobbies/{gameLobby}/distributed-prizes', [
        \App\Http\Controllers\Admin\Lobbies\GameLobbyController::class,
        'distributedPrizes',
    ]);

    Route::put('game-lobbies/{gameLobby}/archived', [
        \App\Http\Controllers\Admin\Lobbies\GameLobbyController::class,
        'archived',
    ]);

    Route::put('game-lobbies/{gameLobby}/state/{state}', [
        \App\Http\Controllers\Admin\Lobbies\GameLobbyController::class,
        'genericApi',
    ]);

    // ***********************************GameCRUD************************************
    Route::resource('games', GamesController::class);

    // ***********************************GameLobbyCRUD************************************
    Route::apiResource('game-lobbies', GameLobbiesController::class)
    ->except(['store']);
});

// User URLs
Route::middleware(['throttle:api', 'auth:sanctum'])->group(function () {
    /**
     * - Games Api
     *     - index: list all available games
     *     - show: get specific game
     */

    /**
     * - Game Lobbies Api
     *     - show: show specific game lobby
     *     - index: list all available game lobbies
     *     - current-user-score: get user score, rank after the game is finished
     *     - join: user join game lobby
     *     - leave: user leaving game lobby
     *     -
     *
     */
    // Route::resource('games.game-lobbies', GameLobbiesController::class)
    //     ->parameters(['game-lobbies' => 'gameLobby'])
    //     ->shallow()
    //     ->only('show', 'index')
    //     ->scoped();

    Route::get('game-lobbies/{gameLobby}/current-user-score', GameLobbyCurrenUserController::class)->name(
        'games.game-lobbies.current-user-score',
    );
    Route::post('game-lobbies/{gameLobby}/join', GameLobbyJoinController::class)->name('games.game-lobbies.join');
    Route::post('game-lobbies/{gameLobby}/leave', GameLobbyLeaveController::class)->name('games.game-lobbies.leave');

    /**
     * - Chat Rooms Api
     *     - Message: Send message to specific chat room
     */
    Route::post('chat-rooms/{chatRoom}/message', ChatRoomMessageController::class)->name('chat-rooms.message');

    /**
     * Notifications Api
     *      - GET Notifications: get a list of all notifications for the current user
     *      - GET Notifications Unread Count: get number of unread notifications count
     *      - PUT Notification read: Mark notification as read
     *      - DELETE notifications: Delete all notifications
     */
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/unread-count', [NotificationController::class, 'unreadNotificationsCount'])->name(
        'notifications.unread-count',
    );
    Route::put('notifications/{notification}/read', MarkNotificationAsReadController::class)->name(
        'notifications.read',
    );
    Route::delete('notifications', DeleteNotificationsController::class)->name('notifications.delete');

    /**
     * Wallet Api
     *      - GET wallet specific transaction log : get log for specific transaction by transaction id
     */
    Route::get('wallet/transaction/{id}/log', UserTransactionShowController::class)->name('user.transactions.show');
});
