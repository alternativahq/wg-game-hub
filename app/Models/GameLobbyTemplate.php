<?php

namespace App\Models;

use App\Models\Concerns\HasUUID;
use App\Builders\GameLobbyTemplatesBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameLobbyTemplate extends Model
{
    use HasUUID;
    use HasFactory;

    protected $guarded = [];

    public function newEloquentBuilder($query): GameLobbyTemplatesBuilder
    {
        return new GameLobbyTemplatesBuilder(query: $query);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
