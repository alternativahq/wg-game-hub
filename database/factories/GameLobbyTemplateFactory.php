<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Asset;
use App\Enums\GameLobbyType;
use App\Enums\GameLobbyStatus;
use Illuminate\Support\Carbon;
use App\Models\GameLobbyTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameLobbyTemplateFactory extends Factory
{
    protected $model = GameLobbyTemplate::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(),
            'algorithm_id' => rand(1,3),
            'description' => $this->faker->text(),
            'image' => null,
            'theme_color' => $this->faker->safeHexColor(),
            'rules' => $this->faker->paragraph(),
            'base_entrance_fee' => rand(5, 10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'asset_id' => Asset::all()->random(),
            'min_players' => rand(1, 2),
            'max_players' => ($mp = rand(4, 5)),
        ];
    }
}
