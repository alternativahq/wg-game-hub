<?php

namespace App\Enums;

enum NotificationType: string
{
    case UserLeftLobby   = "user-left-lobby";
    case UserJoinedLobby = "user-joined-lobby";
    case ResultsProcessing = "we are processing the results ";
    case ResultsProcessed = "we processed the results ";
}
