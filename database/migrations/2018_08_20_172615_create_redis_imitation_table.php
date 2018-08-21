<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * I decided it's too much to deploy and connect redis for such  a small project, so i make some kind of its imitation
 */
class CreateRedisImitationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redis_imitation', function (Blueprint $table) {
            $table->string('key');
            $table->primary('key');

            $table->integer('value');

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
        Schema::dropIfExists('redis_imitation');
    }
}
