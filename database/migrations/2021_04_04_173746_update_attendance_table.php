<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->string('note')->after('userID')->nullable();
            $table->integer('deduction')->after('userID');
            $table->integer('bonus')->after('userID');
            $table->dateTime('checkOut')->nullable()->after('date');
            $table->integer('hour')->after('userID');
            $table->integer('shiftID')->length(13)->unsigned()->after('userID');
            $table->foreign('shiftID')
            ->references('id')
            ->on('shifts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}