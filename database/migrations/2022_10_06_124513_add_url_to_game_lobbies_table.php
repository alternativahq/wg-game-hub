<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('game_lobbies', function (Blueprint $table) {
            $table
                ->text('url')
                ->nullable()
                ->after('start_at');
        });
    }

    public function down()
    {
        Schema::table('game_lobbies', function (Blueprint $table) {
            $table->dropColumn('url');
        });
    }
};
