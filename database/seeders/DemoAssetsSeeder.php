<?php

namespace Database\Seeders;

use App\Models\Asset;
use Illuminate\Database\Seeder;
use Str;

class DemoAssetsSeeder extends Seeder
{
    public function run()
    {
        Asset::insert($this->assets()->toArray());
    }

    protected function assets()
    {
        return collect([
            [
                'id' => '8a16414e-9eb9-46d1-a9b0-6a96bafdd653',
                'name' => 'Banano',
                'description' => 'Banano Blockchain',
                'symbol' => 'BAN',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => '50d345bd-90da-4fc5-af09-ba190039fb85',
                'name' => 'Nano',
                'description' => 'Nano Blockchain',
                'symbol' => 'XNO',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => '39019526-5dae-480f-96cb-7cb83882e90f',
                'name' => 'Wodo Token',
                'description' => 'Wodo Platform Token',
                'symbol' => 'XWGT',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => 'e72908fb-11ef-4a5e-95cd-1a85213d86b7',
                'name' => 'Ethereum',
                'description' => 'Ethereum blockchain',
                'symbol' => 'ETH',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => 'e63480f5-db85-4bd3-a6b2-ca4cab93b2eb',
                'name' => 'AVALANCHE',
                'description' => 'Avalanche blockchain',
                'symbol' => 'AVAX',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => 'ae04bd0e-d955-4053-84d9-4c26c87dc130',
                'name' => 'Binance Smart Chain',
                'description' => 'Binance Smart blockchain',
                'symbol' => 'BSC',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => 'eda4e9a3-2c5b-4b25-99d0-7e3d83faf56f',
                'name' => 'Solano',
                'description' => 'Solano blockchain',
                'symbol' => 'SOL',
                'updated_at' => now(),
                'created_at' => now(),
            ],
        ]);
    }
}
