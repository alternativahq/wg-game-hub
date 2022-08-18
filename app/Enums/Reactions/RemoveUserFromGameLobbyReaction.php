<?php

namespace App\Enums\Reactions;

enum RemoveUserFromGameLobbyReaction
{
    case UserNotInGameLobby;

    public function label(): string
    {
        return match ($this) {
            RemoveUserFromGameLobbyReaction::UserNotInGameLobby => __('gamehub.user_not_in_game_lobby'),
        };
    }
}
