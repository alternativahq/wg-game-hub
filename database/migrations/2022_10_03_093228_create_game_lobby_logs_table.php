<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('game_lobby_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('description');
            $table->json('payload')->nullable();
            $table
                ->foreignUuid('user_id')
                ->nullable()
                ->constrained('users');
            $table->foreignUuid('game_lobby_id')->constrained('game_lobbies');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('game_lobby_logs');
    }
};
