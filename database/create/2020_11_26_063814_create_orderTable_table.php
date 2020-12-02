<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderTables', function (Blueprint $table) {
            $table->increments('orderID');
            $table->integer('userID')->length(13)->unsigned();
            $table->float('total',40);
            $table->dateTime('orderDate');
            $table->string('perNum',255);
            $table->string('service',255);
            $table->dateTime('dateClick');
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
        Schema::dropIfExists('orderTables');
    }
}
