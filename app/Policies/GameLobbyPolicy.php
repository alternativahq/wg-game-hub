<?php

namespace App\Policies;

use App\Models\GameLobby;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GameLobbyPolicy
{
    use HandlesAuthorization;

    public function view(User $user, GameLobby $gameLobby): bool
    {
        return $gameLobby
            ->users()
            ->where('users.id', $user->id)
            ->exists();
    }

    public function join(User $user, GameLobby $gameLobby): bool
    {
        return $gameLobby
            ->users()
            ->where('users.id', $user->id)
            ->doesntExist();
    }

    public function leave(User $user, GameLobby $gameLobby): bool
    {
        return $gameLobby
            ->users()
            ->where('users.id', $user->id)
            ->exists();
    }
}
