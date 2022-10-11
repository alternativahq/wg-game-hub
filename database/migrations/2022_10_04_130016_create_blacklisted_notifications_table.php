<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('blacklisted_notifications', function (Blueprint $table) {
            $table->uuid('idempotency_id')->primary();
            $table->dateTime('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('blacklisted_notifications');
    }
};
