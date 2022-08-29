<?php

namespace Database\Seeders;

use App\Enums\UserAssetAccountStatus;
use App\Models\Asset;
use App\Models\User;
use App\Models\UserAssetAccount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoUserAssetAccountsSeeder extends Seeder
{
    public function run()
    {
        /** @var User $user */
        $x = new DemoUsersSeeder();
        $accounts = $x->users()->map(function ($user) {
            $accounts = collect($user['accounts']);
            return $accounts->map(function ($account, $assetId) use ($user) {
                return [
                    'id' => $account,
                    'user_id' => $user['id'],
                    'asset_id' => $assetId,
                    'balance' => 1_000,
                    'status' => UserAssetAccountStatus::Active,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });
        });
        UserAssetAccount::insert($accounts->flatten(1)->toArray());
    }
}
