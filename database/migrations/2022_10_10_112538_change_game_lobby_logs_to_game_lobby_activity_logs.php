<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::rename('game_lobby_logs', 'game_lobby_activity_logs');
    }

    public function down()
    {
        Schema::rename('game_lobby_activity_logs', 'game_lobby_logs');
    }
};
