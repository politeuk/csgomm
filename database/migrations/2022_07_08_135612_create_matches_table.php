<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->string('match_id');
            $table->foreignId('map_id')->nullable();
            $table->integer('status')->default(0);
            $table->integer('team_1_rounds')->default(0);
            $table->integer('team_2_rounds')->default(0);
            $table->string('token');
            $table->string('demo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matches');
    }
};
