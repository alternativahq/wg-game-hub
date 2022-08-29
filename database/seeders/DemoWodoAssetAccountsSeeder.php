<?php

namespace Database\Seeders;

use App\Enums\UserAssetAccountStatus;
use App\Models\Asset;
use App\Models\WodoAssetAccount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Str;

class DemoWodoAssetAccountsSeeder extends Seeder
{
    public function run()
    {
        WodoAssetAccount::insert($this->wodoAssetsAccounts()->toArray());
    }

    public function wodoAssetsAccounts(): Collection
    {
        return Asset::get()->map(function (Asset $wodoAssetAccount) {
            return [
                'id' => Str::uuid(),
                'asset_id' => $wodoAssetAccount->id,
                'balance' => 1_000_000,
                'status' => UserAssetAccountStatus::Active,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });
    }
}
