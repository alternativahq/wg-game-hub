<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('game_lobby_templates', function (Blueprint $table) {
            $table
                ->bigInteger('game_play_duration')
                ->after('max_players')
                ->nullable();
        });
    }

    public function down()
    {
        Schema::table('game_lobby_templates', function (Blueprint $table) {
            $table->dropColumn('game_play_duration');
        });
    }
};
