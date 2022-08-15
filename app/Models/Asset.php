<?php

namespace App\Models;

use App\Builders\AssetBuilder;
use App\Models\Concerns\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasUUID;
    use SoftDeletes;
    use HasFactory;

    protected $guarded = [];

    public function newEloquentBuilder($query): AssetBuilder
    {
        return new AssetBuilder(query: $query);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_asset_account')
            ->using(UserAssetAccount::class)
            ->withPivot('balance', 'status');
    }

    public function wodoAssetAccounts(): HasMany
    {
        return $this->hasMany(WodoAssetAccount::class);
    }
}
