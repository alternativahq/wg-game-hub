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
        collect([
            [
                'id' => 'aab99eb1-94c4-43b9-a1cf-88431f89a84c',
                'asset_id' => 'aab99eb1-94c4-43b9-a1cf-88431f89a84c',
                'balance' => 1_000_000,
                'status' => UserAssetAccountStatus::Active,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '8a373e8a-da32-4d90-9d66-7df2f5ae208b',
                'asset_id' => '8a373e8a-da32-4d90-9d66-7df2f5ae208b',
                'balance' => 1_000_000,
                'status' => UserAssetAccountStatus::Active,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'a63c976e-d0c2-4e5d-8717-b293169a75ed',
                'asset_id' => 'a63c976e-d0c2-4e5d-8717-b293169a75ed',
                'balance' => 1_000_000,
                'status' => UserAssetAccountStatus::Active,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '5e3c790e-a17f-48a7-86ac-08ef3508b3b9',
                'asset_id' => '5e3c790e-a17f-48a7-86ac-08ef3508b3b9',
                'balance' => 1_000_000,
                'status' => UserAssetAccountStatus::Active,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'f71aff1f-c41f-4f88-bcd5-c8fe67155294',
                'asset_id' => 'f71aff1f-c41f-4f88-bcd5-c8fe67155294',
                'balance' => 1_000_000,
                'status' => UserAssetAccountStatus::Active,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'eea92644-2b81-419c-905a-6b9025394186',
                'asset_id' => 'eea92644-2b81-419c-905a-6b9025394186',
                'balance' => 1_000_000,
                'status' => UserAssetAccountStatus::Active,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '12c0a9b1-c9e4-4027-a3ab-3b59175e37c7',
                'asset_id' => '12c0a9b1-c9e4-4027-a3ab-3b59175e37c7',
                'balance' => 1_000_000,
                'status' => UserAssetAccountStatus::Active,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
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
