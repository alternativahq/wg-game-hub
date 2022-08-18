<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('game_lobby_user', function (Blueprint $table) {
            $table->dropColumn('left_at');
        });
    }
};
