<?php

use App\Http\Controllers\API\{
    ChatRooms\ChatRoomMessageController,
    Games\GameLobbiesController,
    Games\GameLobbyJoinController,
    Games\GameLobbyLeaveController,
    Games\GameLobbyResultsController,
    Games\GamesController,
    Notifications\NotificationController,
    Notifications\SendNotificationController,
    Notifications\MarkNotificationAsReadController,
    Notifications\DeleteNotificationController,
};
use Illuminate\Support\Facades\Route;

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

// Games
Route::resource('games', GamesController::class)->only('index', 'show');

// Game Lobbies
Route::resource('games.game-lobbies', GameLobbiesController::class)
    ->parameters(['game-lobbies' => 'gameLobby'])
    ->shallow()
    ->only('show', 'index')
    ->scoped();

Route::post(
    'game-lobbies/{gameLobby}/join',
    GameLobbyJoinController::class,
)->name('games.game-lobbies.join');

Route::post(
    'game-lobbies/{gameLobby}/leave',
    GameLobbyLeaveController::class,
)->name('games.game-lobbies.leave');

// Should be protected only by internal
Route::post(
    'game-lobbies/{gameLobby}/results',
    GameLobbyResultsController::class,
);

// Chatroom message
Route::post(
    'chat-rooms/{chatRoom}/message',
    ChatRoomMessageController::class,
)->name('chat-rooms.message');

// Notifications
Route::get('notificaions',
    [NotificationController::class,'index'
])->name('notificaions.index');

Route::get('notificaions/unreadnotificationscount',
    [NotificationController::class,
    'unreadnotificationscount'
])->name('notificaions.unreadnotificationscount');

Route::delete('notificaions',
     DeleteNotificationController::class
)->name('notificaions.delete');

Route::put('notificaions/{notification}/read',
    MarkNotificationAsReadController::class
)->name('notificaions.read');

Route::post('notificaions/send',
    SendNotificationController::class
)->name('notificaions.send');
