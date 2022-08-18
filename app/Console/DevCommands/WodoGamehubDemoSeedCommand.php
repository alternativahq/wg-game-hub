<?php

namespace App\Console\DevCommands;

use App\Enums\ChatRoomType;
use App\Enums\GameLobbyStatus;
use App\Enums\GameLobbyType;
use App\Enums\GameStatus;
use App\Enums\UserAssetAccountStatus;
use App\Models\Achievement;
use App\Models\Asset;
use App\Models\UserAchievement;
use App\Models\UserAssetAccount;
use App\Models\ChatRoom;
use App\Models\Game;
use App\Models\GameLobby;
use App\Models\User;
use App\Models\GameLobbyUserScore;
use App\Models\WodoAssetAccount;
use Database\Factories\AchievementFactory;
use Database\Factories\GameFactory;
use Database\Factories\UserFactory;
use Database\Seeders\DemoAssetsSeeder;
use Database\Seeders\DemoGameAchievementsSeeder;
use Database\Seeders\DemoGamesSeeder;
use Database\Seeders\DemoUserAssetAccountsSeeder;
use Database\Seeders\DemoUsersSeeder;
use Database\Seeders\DemoWodoAssetAccountsSeeder;
use Database\Seeders\GeneralChatRoomSeeder;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class WodoGamehubDemoSeedCommand extends Command
{
    protected $signature = 'wodo:gamehub-demo-seed';

    protected $description = 'Clean and seed the database with demo data';

    public function getRandomImageForGame(Game $game)
    {
        $images = collect([
            // Tank
            'fdaa08b1-07c4-4d29-aeaf-457285bd1ef5' => [
                'tank/homepage_bg.png',
                'tank/Tanks-screenshot.png',
                'tank/Tankgenesiss-sshot2.png',
                'tank/Tankgenesis-screenshot1.png',
                'tank/Tank-genesis-website-bg.png',
                'tank/Tank-Genesis-Cover-art.png',
                'tank/sample.png',
                'tank/sample_bg.png',
                'tank/LogoTank.svg',
                'tank/image_044_0000.png',
                'tank/image_031_0000.png',
                'tank/homepage_bg.png',
            ],
            // Tankx
            'a9dad87e-0fd7-449f-a011-c09d45fc8ada' => [
                'tankx/tankx_1.png',
                'tankx/tankx_2.png',
                'tankx/tankx_cover.png',
                'tankx/tankx_logo.png',
            ],
            // Wodo land
            '8f96c6ec-7003-4c5b-b469-4ee0fd1cb42b' => [
                'wodoland/wodoland_1.jpg',
                'wodoland/wodoland_10.png',
                'wodoland/wodoland_2.png',
                'wodoland/wodoland_3.png',
                'wodoland/wodoland_4.png',
                'wodoland/wodoland_5.png',
                'wodoland/wodoland_6.png',
                'wodoland/wodoland_7.png',
                'wodoland/wodoland_8.png',
                'wodoland/wodoland_cover.png',
                'wodoland/wodoland_cover_1.png',
                'wodoland/wodoland_cover_2.png',
            ],
            // Wodo Shooter
            '1000a104-f10d-44ea-8a21-9a6dba27408b' => [
                'wfps/wffps_7.png',
                'wfps/wfps_1.jpg',
                'wfps/wfps_2.jpg',
                'wfps/wfps_3.jpg',
                'wfps/wfps_4.png',
                'wfps/wfps_5.png',
                'wfps/wfps_6.png',
                'wfps/wfps_cover_2.png',
                'wfps/wodo_shooter_cover.png',
            ],
            // slither io
            '2934ceee-e195-4cd0-ae6a-d2098c810917' => [
                'shilterio/slitherio_1.jpg',
                'shilterio/slitherio_2.jpg',
                'shilterio/slitherio_3.jpg',
                'shilterio/slitherio_4.jpg',
                'shilterio/slitherio_5.jpg',
                'shilterio/slitherio_6.jpg',
                'shilterio/shilterio_cover.png',
            ],
            // agario
            '753501ba-a9fa-437b-8b44-8d8ca42f18ab' => [
                'agario/agario_1.png',
                'agario/agario_2.jpg',
                'agario/agario_3.jpg',
                'agario/agario_4.jpg',
                'agario/agario_5.jpg',
                'agario/agario_6.jpg',
                'agario/agario_cover.jpg',
            ],
        ]);

        if ($imagesArray = $images->get($game->id)) {
            return Arr::random($imagesArray);
        }

        return null;
    }

    public function handle()
    {
        $this->call('migrate:fresh');
        $this->info('Seeding...');
        $this->call(GeneralChatRoomSeeder::class);
        $this->call(DemoUsersSeeder::class);
        $this->call(DemoAssetsSeeder::class);
        $this->call(DemoGamesSeeder::class);
        // Game achievements
        $this->call(DemoWodoAssetAccountsSeeder::class);
        $this->call(DemoUserAssetAccountsSeeder::class);
        $this->call(DemoGameAchievementsSeeder::class);

        $users = User::all();
        /** @var Game $game */
        foreach (Game::cursor() as $game) {
            GameLobby::factory()
                ->count(count: 30)
                ->for($game)
                ->state(
                    new Sequence(function (Sequence $sequance) use ($game) {
                        return [
                            'asset_id' => Asset::all()->random(),
                            'status' => GameLobbyStatus::Scheduled,
                            'scheduled_at' => now()->addHours(rand(5, 200)),
                            'image' => $this->getRandomImageForGame($game),
                        ];
                    }),
                )
                ->has(
                    ChatRoom::factory()
                        ->count(1)
                        ->state(function (array $attributes, GameLobby $gameLobby) {
                            return [
                                'id' => $gameLobby->id,
                                'type' => ChatRoomType::GameLobby,
                            ];
                        }),
                )
                ->create();

            // decrease the fee for each user joined this lobby
            $lobbies = GameLobby::factory()
                ->scheduledInPast()
                ->count(14)
                ->for($game)
                ->state(
                    new Sequence(function ($sequance) {
                        return [
                            'asset_id' => Asset::all()->random(),
                            'status' => GameLobbyStatus::Archived,
                            'image' => Arr::random([
                                'tankx/tankx_1.png',
                                'tankx/tankx_2.png',
                                'tankx/tankx_cover.png',
                                'tankx/tankx_logo.png',
                            ]),
                        ];
                    }),
                )
                ->hasAttached($users, function ($attributes) {
                    return [
                        'entrance_fee' => $attributes['base_entrance_fee'],
                        'joined_at' => now(),
                    ];
                })
                ->has(
                    ChatRoom::factory()
                        ->count(1)
                        ->hasAttached($users)
                        ->state(function (array $attributes, GameLobby $gameLobby) {
                            return [
                                'id' => $gameLobby->id,
                                'type' => ChatRoomType::GameLobby,
                            ];
                        }),
                )
                ->create();

            $gameAchievements = Achievement::where('game_id', $game->id)->get();

            foreach ($lobbies as $lobby) {
                $users = $lobby->users;

                $scores = $users->map(function (User $user, $index) use ($lobby) {
                    return new GameLobbyUserScore([
                        'game_id' => $lobby->game_id,
                        'game_lobby_id' => $lobby->id,
                        'user_id' => $user->id,
                        'rank' => rand(1, 200),
                        'score' => rand(100, 3000),
                        'time_played' => rand(100, 4000),
                    ]);
                });
                $lobby->scores()->saveMany($scores);

                $achievements = $users->map(function (User $user, $index) use ($lobby, $gameAchievements) {
                    $a = $gameAchievements->pop();
                    return new UserAchievement([
                        'game_id' => $lobby->game_id,
                        'user_id' => $user->id,
                        'game_lobby_id' => $lobby->id,
                        'achievement_id' => $a->id,
                        'additional_info' => $a->description,
                        'created_at' => now()->subDays(rand(1, 100)),
                        'updated_at' => now(),
                    ]);
                });
                $lobby->usersAchievements()->saveMany($achievements);

                foreach (
                    $lobby
                        ->users()
                        ->with('assetAccounts')
                        ->cursor()
                    as $user
                ) {
                    $user->assetAccounts
                        ->where('asset_id', $lobby->asset_id)
                        ->first()
                        ->decrement('balance', $lobby->base_entrance_fee);
                }
            }
        }
        $this->info('Database has been seeded');
    }
}
