<?php

namespace App\Models;

use App\Models\Concerns\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Builders\AchievementBuilder;

class Achievement extends Model
{
    use HasUUID;
    use HasFactory;

    protected $guarded = [];
    
    public function newEloquentBuilder($query): AchievementBuilder
    {
        return new AchievementBuilder(query: $query);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_achievements')
            ->using(UserAchievement::class)
            ->withPivot('game_id', 'game_lobby_id', 'additional_info');
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}
