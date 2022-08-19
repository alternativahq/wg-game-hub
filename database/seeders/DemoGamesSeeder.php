<?php

namespace Database\Seeders;

use App\Enums\GameStatus;
use App\Models\Game;
use Illuminate\Database\Seeder;
use Str;

class DemoGamesSeeder extends Seeder
{
    public function run()
    {
        Game::insert($this->games()->toArray());
    }

    protected function games()
    {
        return collect([
            [
                'id' => '8f96c6ec-7003-4c5b-b469-4ee0fd1cb42b',
                'name' => 'Wodoland',
                'description' =>
                    'Wodoland is the first game design and implementation built on top of the wodo gaming platform using the wodo development kit(SDK) ',
                'status' => GameStatus::Online,
                'image' => 'wodoland/wodoland_cover.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '1000a104-f10d-44ea-8a21-9a6dba27408b',
                'name' => 'Wodo Shooter',
                'description' => 'Wodo Shooter, WFPS another game from Wodo Team',
                'status' => GameStatus::Online,
                'image' => 'wfps/wodo_shooter_cover.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'fdaa08b1-07c4-4d29-aeaf-457285bd1ef5',
                'name' => 'Tank',
                'description' =>
                    'Tank is a Massively-multiplayer top-down strategy browser game. In Tank, the player manipulates a tanks using the mouse and keyboard buttons.',
                'status' => GameStatus::Online,
                'image' => 'tank/homepage_bg.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'a9dad87e-0fd7-449f-a011-c09d45fc8ada',
                'name' => 'Tankx',
                'description' =>
                    'Tankx is a Massively-multiplayer top-down strategy browser game. In Tank, the player manipulates a tanks using the mouse and keyboard buttons.',
                'status' => GameStatus::Online,
                'image' => 'tankx/tankx_logo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '753501ba-a9fa-437b-8b44-8d8ca42f18ab',
                'name' => 'Agar.io',
                'description' =>
                    'Agar.io is a Massively-multiplayer top-down strategy browser game. In Agar.io, the player manipulates a circular cell using the mouse and keyboard buttons.',
                'status' => GameStatus::Online,
                'image' => 'agario/agario_cover.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '2934ceee-e195-4cd0-ae6a-d2098c810917',
                'name' => 'Slither.io',
                'description' =>
                    'Slither.io is a massively multiplayer browser game where players control a snake-like avatar, which consumes multicolored pellets from other players, and ones that naturally spawn on the map in the game to grow in size. The objective of the game is to grow the longest snake in the server.',
                'status' => GameStatus::Online,
                'image' => 'shilterio/shilterio_cover.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
