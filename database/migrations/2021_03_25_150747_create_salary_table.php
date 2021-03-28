<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salarys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('specificSalaryID')->length(13)->unsigned();;
            $table->integer('totalDate');
            $table->integer('bonus');
            $table->integer('deduction');
            $table->integer('month');
            $table->integer('total');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->foreign('specificSalaryID')
            ->references('id')
            ->on('specificSalarys')
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
        Schema::dropIfExists('salarys');
    }
}