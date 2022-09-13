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
    /**
     * Game Lobby Api:
     *     - results: receive players results from game server
     *     - status start: change game lobby to in-lobby
     *     - status in-game: change game lobby to in-game
     *     - status game-ended: change game to ended
     */
    Route::post('game-lobbies/{gameLobby}/started', GameLobbyStartController::class)->name(
        'games.game-lobbies.started',
    );
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
