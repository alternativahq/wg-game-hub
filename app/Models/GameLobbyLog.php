<?php

namespace App\Models;

use App\Models\Concerns\HasUUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameLobbyLog extends Model
{
    use HasUUID;
    use HasFactory;

    protected $guarded = [];

    public function gameLobby(): BelongsTo
    {
        return $this->belongsTo(GameLobby::class);
    }
}
