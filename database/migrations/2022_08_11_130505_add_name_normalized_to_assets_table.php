<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table
                ->string('name_normalized')
                ->virtualAs("regexp_replace(name, '[^A-Za-z0-9]', '')")
                ->after('name')
                ->index();
        });
    }

    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {});
    }
};
