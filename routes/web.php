<?php

use App\Http\Controllers\{
    GamesController,
    ChatRooms\ChatRoomMessageController,
    DashboardController,
    GameLobbies\GameLobbyJoinController,
    GameLobbies\GameLobbyLeaveController,
    GameLobbies\GameLobbiesController,
    ProfileController,
    User\AchievementsController as UserAchievementsController,
    User\AssetAccountsController as UserAssetAccountsController,
    User\DashboardController as UserDashboardController,
    User\GamePlayedHistoryController as UserGamePlayedHistoryController,
    Wallet\TransactionController as UserTransactionController,
    Wallet\WithdrawController as UserWithdrawController,
    Wallet\DepositController as UserDepositController,
    Notifications\DeleteNotificationsController,
    Notifications\MarkNotificationAsReadController,
    Admin\GamesController as AdminGamesController,
    Admin\GameLobbiesController as AdminGameLobbiesController,
    Admin\GameLobbiesShowController as AdminGameLobbiesShowController,
};
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name(name: 'landing');
Route::resource('games', GamesController::class)->only('show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', ProfileController::class)
        ->middleware('auth')
        ->name(name: 'profile');

    Route::resource('games.game-lobbies', GameLobbiesController::class)
        ->parameters(['game-lobbies' => 'gameLobby'])
        ->shallow()
        ->only('show')
        ->scoped();

    // GameLobbies
    Route::post('game-lobbies/{gameLobby}/join', GameLobbyJoinController::class)
        ->name('games.game-lobbies.join')
        ->middleware('EnsureUserIsNotInCooldownPeriod');

    Route::delete('game-lobbies/{gameLobby}/leave', GameLobbyLeaveController::class)->name('games.game-lobbies.leave');

    // Chat Rooms
    Route::post('chat-rooms/{chatRoom}/message', ChatRoomMessageController::class)->name('chat-rooms.message');

    Route::get('/w/{user:username}', UserDashboardController::class)->name('user.profile');
    Route::get('/w/{user:username}/achievements', UserAchievementsController::class)->name('user.achievements');
    Route::get('/w/{user:username}/asset-accounts', UserAssetAccountsController::class)->name('user.assetAccounts');
    Route::get('/w/{user:username}/games-played-history', UserGamePlayedHistoryController::class)->name(
        'user.games-played-history',
    );
    // User Transactions
    Route::get('/wallet/transactions', UserTransactionController::class)->name('user.transactions');
    Route::get('/wallet/withdraw', UserWithdrawController::class)->name('user.withdraw');
    Route::get('/wallet/deposit', UserDepositController::class)->name('user.deposit');
    // Notifications
    Route::put('notifications/{notification}/read', MarkNotificationAsReadController::class)->name(
        'notifications.read',
    );

    Route::delete('notifications', DeleteNotificationsController::class)->name('notifications.delete');

    // Admin Routes
    Route::middleware('isAdmin')->prefix('/admin')->as('admin-')->group(function () {
        // CRAD opretion  game llobies 
        Route::get('/games', AdminGamesController::class)->name('games');
        Route::get('/games/{game}/lobbies', AdminGameLobbiesShowController::class)->name('game-lobbies');
        Route::resource('game.gameLobies', AdminGameLobbiesController::class)->except('index','show');
    });
});
