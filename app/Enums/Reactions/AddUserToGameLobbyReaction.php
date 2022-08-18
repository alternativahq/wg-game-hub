<?php

namespace App\Enums\Reactions;

enum AddUserToGameLobbyReaction
{
    case NoAvailableSpots;
    case UserAlreadyJoinedTheGameLobby;
    case InsufficientFunds;

    public function label(): string
    {
        return match ($this) {
            AddUserToGameLobbyReaction::NoAvailableSpots => __('gamehub.no_available_spots'),
            AddUserToGameLobbyReaction::UserAlreadyJoinedTheGameLobby => __('gamehub.user_already_joined_the_game_lobby'),
            AddUserToGameLobbyReaction::InsufficientFunds => __('gamehub.insufficient_funds'),
        };
    }
}
