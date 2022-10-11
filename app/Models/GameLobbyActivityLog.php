<?php

namespace App\Models;

use App\Enums\GameLobbyLogType;
use App\Models\Concerns\HasUUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameLobbyActivityLog extends Model
{
    use HasUUID;
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'name' => GameLobbyLogType::class,
        'payload' => 'json',
    ];

    public function gameLobby(): BelongsTo
    {
        return $this->belongsTo(GameLobby::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
