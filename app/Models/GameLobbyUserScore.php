<?php

namespace App\Models;

use App\Builders\GameLobbyUserScoreBuilder;
use App\Models\Concerns\HasUUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameLobbyUserScore extends Model
{
    use HasUUID;

    protected $table = 'game_lobby_user_score';

    protected $guarded = [];

    public function newEloquentBuilder($query): Builder
    {
        return new GameLobbyUserScoreBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gameLobby(): BelongsTo
    {
        return $this->belongsTo(GameLobby::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
