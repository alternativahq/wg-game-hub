<?php

namespace App\Models;

use App\Enums\GameLobbyType;
use App\Enums\GameLobbyStatus;
use App\Enums\GameLobbyLogType;
use App\Models\Concerns\HasUUID;
use App\Builders\GameLobbyBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GameLobby extends Model
{
    use SoftDeletes;
    use HasFactory;
    use HasUUID;

    protected $guarded = [];

    protected $casts = [
        'type' => GameLobbyType::class,
        'state' => GameLobbyStatus::class,
    ];

    protected $dates = ['scheduled_at', 'start_at'];

    protected $appends = ['prize_pool','has_available_spots', 'players_in_lobby_count', 'scheduled_at_utc_string', 'start_at_utc_string', 'image_url'];

    public function imageUrl(): Attribute
    {
        return new Attribute(
            get: function () {
                if ($this->image) {
                    return Storage::disk('s3')->url($this->image);
                }
                return "https://picsum.photos/seed/{$this->id}/1280/720";
            },
        );
    }

    public function newEloquentBuilder($query): GameLobbyBuilder
    {
        return new GameLobbyBuilder(query: $query);
    }

    public function hasAvailableSpots(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->available_spots > 0 && $this->available_spots <= $this->max_players;
            },
        );
    }

    public function scheduledAtUtcString(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->scheduled_at?->toString();
            },
        );
    }
    public function startAtUtcString(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->start_at?->toString();
            },
        );
    }

    public function scheduledAtToDateTime(): Attribute
    {
        return new Attribute(
            get: function () {
                return date('Y-m-d\TH:i', strtotime($this->scheduled_at));
            },
        );
    }
    public function PrizePool(): Attribute
    {
        return new Attribute(
            get: function ($value = 0) {
                return  $value;
            },
            set: function ($value = 0) {
                return  $value;
            },
        );
    }

    public function playersInLobbyCount(): Attribute
    {
        return new Attribute(
            get: function () {
                return abs($this->available_spots - $this->max_players);
            },
        );
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(GameLobbyUser::class)
            ->withPivot(['entrance_fee', 'joined_at']);
    }

    public function chatRoom(): HasOne
    {
        return $this->hasOne(ChatRoom::class, 'id');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(GameLobbyUserScore::class);
    }

    public function usersAchievements(): HasMany
    {
        return $this->hasMany(UserAchievement::class);
    }

    public function calculateThePrize(): float
    {
        $total = GameLobbyUser::where('game_lobby_id', $this->id)->sum('entrance_fee');
        return (float) ($total - ($total * 20.0) / 100.0);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(GameLobbyActivityLog::class);
    }
}
