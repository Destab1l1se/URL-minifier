<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedirectFactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redirect_facts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('url_id');
            $table->foreign('url_id')->references('id')->on('urls');

            $table->string('country');
            $table->string('language');
            $table->string('browser');
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
        Schema::dropIfExists('redirect_facts');
    }
}
