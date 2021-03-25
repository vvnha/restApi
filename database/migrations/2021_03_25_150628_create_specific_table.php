<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecificTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('specificSalarys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userID')->length(13)->unsigned();
            $table->integer('kindOfSalaryID')->length(13)->unsigned();
            $table->timestamps();
            $table->foreign('userID')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            $table->foreign('kindOfSalaryID')
            ->references('id')
            ->on('kindOfSalarys')
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
        Schema::dropIfExists('specificSalarys');
    }
}
