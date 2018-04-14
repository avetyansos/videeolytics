<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalyticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analytics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sessionId', 128)->unique();
            $table->string('userIdentifier')->nullable();
            $table->timestamp('startTime');
            $table->integer('duration');

            $table->string('deviceId');
            $table->string('deviceModel');
            $table->enum('platform', ['ios', 'android']);
            $table->string('osVersion');

            $table->text('crash')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analytics');
    }
}
