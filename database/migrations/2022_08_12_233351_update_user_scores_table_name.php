<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::rename('user_scores', 'game_lobby_user_score');
    }

    public function down()
    {
        Schema::rename('game_lobby_user_score', 'user_scores');
    }
};
