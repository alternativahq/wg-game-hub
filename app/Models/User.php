<?php

namespace App\Models;

use App\Models\Concerns\HasUUID;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Request;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasUUID;

    protected $fillable = ['name', 'last_name', 'email', 'password', 'username', 'is_admin', 'cooldown_end_at'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'cooldown_end_at' => 'datetime',
    ];

    protected $appends = ['full_name', 'image_url', 'is_in_cooldown_period'];

    public function receivesBroadcastNotificationsOn(): string
    {
        return 'user.' . $this->id;
    }

    public function gameLobbies(): BelongsToMany
    {
        return $this->belongsToMany(GameLobby::class);
    }

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->name . ' ' . $this->last_name;
            },
        );
    }

    public function chatRooms(): BelongsToMany
    {
        return $this->belongsToMany(ChatRoom::class)->using(ChatRoomUser::class);
    }

    public function assets(): BelongsToMany
    {
        return $this->belongsToMany(Asset::class, 'user_asset_account')
            ->withPivot('balance', 'status')
            ->using(UserAssetAccount::class);
    }

    public function assetAccounts(): HasMany
    {
        return $this->hasMany(UserAssetAccount::class);
    }

    public function imageUrl(): Attribute
    {
        return new Attribute(
            get: function () {
                return "https://avatars.dicebear.com/api/adventurer/{$this->username}.svg";
            },
        );
    }

    public function gamesScores(): HasMany
    {
        return $this->hasMany(GameLobbyUserScore::class);
    }

    public function withdrawalConfirmations(): HasMany
    {
        return $this->hasMany(WithdrawalConfirmation::class);
    }

    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')->withPivot(
            'game_id',
            'game_lobby_id',
            'additional_info',
        );
    }

    public function isInCooldownPeriod(): Attribute
    {
        return new Attribute(
            get: function () {
                return !is_null($this->cooldown_end_at) && $this->cooldown_end_at->isAfter(now());
            },
        );
    }

    public function resetCooldown()
    {
        if (!is_null($this->cooldown_ended_at)) {
            $this->update([
                'cooldown_end_at' => null,
            ]);
        }
    }
}
