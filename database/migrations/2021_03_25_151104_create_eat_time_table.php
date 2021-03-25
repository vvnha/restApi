<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEatTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eatTimes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orderID')->length(13)->unsigned();;
            $table->integer('eatTime');
            $table->timestamps();
            $table->foreign('orderID')
            ->references('orderID')
            ->on('orderTables')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eatTimes');
    }
}
