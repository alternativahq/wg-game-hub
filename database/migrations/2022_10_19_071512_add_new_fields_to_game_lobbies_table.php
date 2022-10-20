<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('game_lobbies', function (Blueprint $table) {
            $table
                ->bigInteger('game_start_delay_time')
                ->after('max_players')
                ->nullable();
            $table
                ->bigInteger('game_start_delay_limit')
                ->after('max_players')
                ->nullable();
            $table
                ->bigInteger('game_start_delay_count')
                ->default(0);
        });
    }

    public function down()
    {
        Schema::table('game_lobbies', function (Blueprint $table) {
            $table->dropColumn('game_start_delay_time');
            $table->dropColumn('game_start_delay_limit');
            $table->dropColumn('game_start_delay_count');
        });
    }
};
