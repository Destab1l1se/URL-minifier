<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedirectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redirects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('url_id');
            $table->foreign('url_id')->references('id')->on('urls');

            $table->string('ip');
            $table->string('language');

            // info from User-Agent
            $table->string('browser');
            $table->double('cssversion');
            $table->boolean('javascript');
            $table->boolean('vbscript');
            $table->boolean('javaapplets');
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
        Schema::dropIfExists('redirects');
    }
}
