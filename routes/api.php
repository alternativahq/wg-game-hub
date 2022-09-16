<?php

use App\Http\Controllers\API\{
    ChatRooms\ChatRoomMessageController,
    Games\GameLobbiesController,
    Games\GameLobbyCurrenUserController,
    Games\GameLobbyJoinController,
    Games\GameLobbyLeaveController,
    Games\GameLobbyResultsController,
    Games\GameLobbyStatus\GameLobbyEndedController,
    Games\GameLobbyStatus\GameLobbyStartController,
    Games\GamesController,
    Wallet\TransactionShowController as UserTransactionShowController,
    Notifications\DeleteNotificationsController,
    Notifications\MarkNotificationAsReadController,
    Notifications\NotificationController,
    Notifications\SendNotificationController,
};
use Illuminate\Support\Facades\Route;

// Machine to Machine
Route::middleware('api.basic-auth')->group(function () {
    Route::post('notifications', SendNotificationController::class)->name('notifications.send');

    Route::post('game-lobbies', [\App\Http\Controllers\Admin\Lobbies\GameLobbyController::class, 'store']);

    Route::put('game-lobbies/{gameLobby}/awaiting-players', [
        \App\Http\Controllers\Admin\Lobbies\GameLobbyController::class,
        'toAwaitingPlayers',
    ]);
    Route::put('game-lobbies/{gameLobby}/in-game', [
        \App\Http\Controllers\Admin\Lobbies\GameLobbyController::class,
        'inGame',
    ])->name('games.game-lobbies.start');

    Route::put('game-lobbies/{gameLobby}/game-ended', [
        \App\Http\Controllers\Admin\Lobbies\GameLobbyController::class,
        'gameEnded',
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

    Route::post('game-lobbies/{gameLobby}/results', GameLobbyResultsController::class);
    Route::post('game-lobbies/{gameLobby}/archive', GameLobbyEndedController::class)->name(
        'games.game-lobbies.archive',
    );
});

// User URLs
Route::middleware(['throttle:api', 'auth:sanctum'])->group(function () {
    /**
     * - Games Api
     *     - index: list all available games
     *     - show: get specific game
     */
    Route::resource('games', GamesController::class)->only('index', 'show');

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
    Route::resource('games.game-lobbies', GameLobbiesController::class)
        ->parameters(['game-lobbies' => 'gameLobby'])
        ->shallow()
        ->only('show', 'index')
        ->scoped();

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
