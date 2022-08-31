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
                'id' => '2c5a57a7-c6c2-4dec-993c-fc28df5dfe4d',
                'name' => 'Banano',
                'description' => 'Banano Blockchain',
                'symbol' => 'BAN',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => '9f343108-afdc-422e-9d40-9ecd83d4cd67',
                'name' => 'Nano',
                'description' => 'Nano Blockchain',
                'symbol' => 'XNO',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => '15f89a3a-c8dd-4be7-86df-cf450a7cfc13',
                'name' => 'Wodo Token',
                'description' => 'Wodo Platform Token',
                'symbol' => 'XWGT',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => 'a8745d72-53a7-493e-b207-7b7ebbec0d40',
                'name' => 'Ethereum',
                'description' => 'Ethereum blockchain',
                'symbol' => 'ETH',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => 'd3a35442-0a55-46c3-850b-320a90ea9a7b',
                'name' => 'AVALANCHE',
                'description' => 'Avalanche blockchain',
                'symbol' => 'AVAX',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => 'a3a5a587-7799-4b47-b72a-ec2eb7d0280f',
                'name' => 'Binance Smart Chain',
                'description' => 'Binance Smart blockchain',
                'symbol' => 'BSC',
                'updated_at' => now(),
                'created_at' => now(),
            ],
            [
                'id' => '85e1fe15-fa5d-4f2c-ae45-f9c643d51657',
                'name' => 'Solano',
                'description' => 'Solano blockchain',
                'symbol' => 'SOL',
                'updated_at' => now(),
                'created_at' => now(),
            ],
        ]);
    }
}
