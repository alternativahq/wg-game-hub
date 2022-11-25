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
                ->integer('commission')
                ->default(20);
        });
    }

    public function down()
    {
        Schema::table('game_lobby_templates', function (Blueprint $table) {
            $table->dropColumn('commission');
        });
    }
};
