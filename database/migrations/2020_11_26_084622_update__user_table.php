<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->foreign('userID')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('userID')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            
        });

        Schema::table('orderTables', function (Blueprint $table) {
            $table->foreign('userID')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('positionID')
                    ->references('positionID')
                    ->on('positions')
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
        Schema::dropIfExists('orderDetails');
    }
}
