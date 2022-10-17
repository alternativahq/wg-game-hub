<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('withdrawal_confirmations', function (Blueprint $table) {
            $table->string('coin');
            $table->double('amount', 30, 2);
            $table->string('wallet_address');
            $table->string('network');
        });
    }

    public function down()
    {
        Schema::table('withdrawal_confirmations', function (Blueprint $table) {
            $table->dropColumn('coin');
            $table->dropColumn('amount');
            $table->dropColumn('wallet_address');
            $table->dropColumn('network');
        });
    }
};
