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
                'asset_id' => '39019526-5dae-480f-96cb-7cb83882e90f',
                'balance' => 1_000_000,
                'status' => UserAssetAccountStatus::Active,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '9f343108-afdc-422e-9d40-9ecd83d4cd67',
                'asset_id' => '8a373e8a-da32-4d90-9d66-7df2f5ae208b',
                'balance' => 1_000_000,
                'status' => UserAssetAccountStatus::Active,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'a63c976e-d0c2-4e5d-8717-b293169a75ed',
                'asset_id' => '8a16414e-9eb9-46d1-a9b0-6a96bafdd653',
                'balance' => 1_000_000,
                'status' => UserAssetAccountStatus::Active,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '5e3c790e-a17f-48a7-86ac-08ef3508b3b9',
                'asset_id' => 'e72908fb-11ef-4a5e-95cd-1a85213d86b7',
                'balance' => 1_000_000,
                'status' => UserAssetAccountStatus::Active,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'f71aff1f-c41f-4f88-bcd5-c8fe67155294',
                'asset_id' => 'ae04bd0e-d955-4053-84d9-4c26c87dc130',
                'balance' => 1_000_000,
                'status' => UserAssetAccountStatus::Active,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'eea92644-2b81-419c-905a-6b9025394186',
                'asset_id' => 'e63480f5-db85-4bd3-a6b2-ca4cab93b2eb',
                'balance' => 1_000_000,
                'status' => UserAssetAccountStatus::Active,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '12c0a9b1-c9e4-4027-a3ab-3b59175e37c7',
                'asset_id' => 'eda4e9a3-2c5b-4b25-99d0-7e3d83faf56f',
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
