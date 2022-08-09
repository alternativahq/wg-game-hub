<?php

namespace App\Enums;

enum NotificationType: string
{
    case UserLeftLobby   = "user-left-lobby";
    case UserJoinedLobby = "user-joined-lobby";
}
