<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSpecificTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('specificSalarys', function (Blueprint $table) {
        //     $table->foreign('userID')
        //     ->references('id')
        //     ->on('users')
        //     ->onDelete('cascade');
        //     $table->foreign('kindOfSalaryID')
        //     ->references('id')
        //     ->on('kindOfSalarys')
        //     ->onDelete('cascade');
            
        // });
        // Schema::table('salarys', function (Blueprint $table) {
        //     $table->foreign('specificSalaryID')
        //     ->references('id')
        //     ->on('specificSalarys')
        //     ->onDelete('cascade');
        // });
        // Schema::table('attendances', function (Blueprint $table) {
        //     $table->foreign('userID')
        //     ->references('id')
        //     ->on('users')
        //     ->onDelete('cascade');
        // });
        // Schema::table('eatTimes', function (Blueprint $table) {
        //     $table->foreign('orderID')
        //     ->references('orderID')
        //     ->on('orderTables')
        //     ->onDelete('cascade');
        // });
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
