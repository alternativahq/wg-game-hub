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
                'id' => 'a63c976e-d0c2-4e5d-8717-b293169a75ed',
                'name' => 'Banano',
                'description' => 'Banano Blockchain',
                'symbol' => 'BAN',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => '8a373e8a-da32-4d90-9d66-7df2f5ae208b',
                'name' => 'Nano',
                'description' => 'Nano Blockchain',
                'symbol' => 'XNO',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => 'aab99eb1-94c4-43b9-a1cf-88431f89a84c',
                'name' => 'Wodo Token',
                'description' => 'Wodo Platform Token',
                'symbol' => 'XWGT',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => '5e3c790e-a17f-48a7-86ac-08ef3508b3b9',
                'name' => 'Ethereum',
                'description' => 'Ethereum blockchain',
                'symbol' => 'ETH',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => 'eea92644-2b81-419c-905a-6b9025394186',
                'name' => 'AVALANCHE',
                'description' => 'Avalanche blockchain',
                'symbol' => 'AVAX',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => 'f71aff1f-c41f-4f88-bcd5-c8fe67155294',
                'name' => 'Binance Smart Chain',
                'description' => 'Binance Smart blockchain',
                'symbol' => 'BSC',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => '12c0a9b1-c9e4-4027-a3ab-3b59175e37c7',
                'name' => 'Solana',
                'description' => 'Solana blockchain',
                'symbol' => 'SOL',
                'updated_at' => now(),
                'created_at' => now(),
            ],
        ]);
    }
}
