<?php

namespace App\DataTransferObjects;

use App\Http\Requests\Admin\StoreGameLobbyRequest;
use Carbon\Carbon;

class GameLobbyServiceData
{
    public function __construct(
        public readonly string $id,
        public readonly string $gameId,
        public readonly string $name,
        public readonly string $description,
        public readonly string $image,
        public readonly string $themeColor,
        public readonly string $type,
        public readonly string $rules,
        public readonly float $baseEntranceFee,
        public readonly float $minPlayers,
        public readonly float $maxPlayers,
        public readonly Carbon $scheduledAt,
        public readonly Carbon $startAt,
        public readonly string $asset,
    ) {
    }
}
