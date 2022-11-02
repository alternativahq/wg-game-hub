<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum GameLobbyAbourtCause: string
{
    case NOT_ENOUGH_USERS = 'NOT_ENOUGH_USERS';
    case GAME_SERVER_CRASHED = 'GAME_SERVER_CRASHED';
    case ABORTED_BY_ADMIN = 'ABORTED_BY_ADMIN';
}
