<?php

use App\Http\Controllers\API\{
    ChatRooms\ChatRoomMessageController,
    Games\GameLobbiesController,
    Games\GameLobbyJoinController,
    Games\GameLobbyLeaveController,
    Games\GameLobbyResultsController,
    Games\GamesController,
    Wallet\TransactionShowController as UserTransactionShowController,
    Notifications\NotificationController,
    Notifications\SendNotificationController,
    Notifications\MarkNotificationAsReadController,
    Notifications\DeleteNotificationsController,
};
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:api')->group(function () {
    // Games
    Route::resource('games', GamesController::class)->only('index', 'show');

    // Game Lobbies
    Route::resource('games.game-lobbies', GameLobbiesController::class)
        ->parameters(['game-lobbies' => 'gameLobby'])
        ->shallow()
        ->only('show', 'index')
        ->scoped();

    Route::post('game-lobbies/{gameLobby}/join', GameLobbyJoinController::class)->name('games.game-lobbies.join');

    Route::post('game-lobbies/{gameLobby}/leave', GameLobbyLeaveController::class)->name('games.game-lobbies.leave');

    // Should be protected only by internal
    Route::post('game-lobbies/{gameLobby}/results', GameLobbyResultsController::class);

    // Chatroom message
    Route::post('chat-rooms/{chatRoom}/message', ChatRoomMessageController::class)->name('chat-rooms.message');

    //transaction show
    Route::get('wallet/transaction/{id}/log', UserTransactionShowController::class)->name('user.transactions.show');

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');

    Route::get('notifications/unread-count', [NotificationController::class, 'unreadNotificationsCount'])->name(
        'notifications.unread-count',
    );

    Route::put('notifications/{notification}/read', MarkNotificationAsReadController::class)->name(
        'notifications.read',
    );

    Route::delete('notifications', DeleteNotificationsController::class)->name('notifications.delete');
});

Route::post('notifications', SendNotificationController::class)->name('notifications.send');
