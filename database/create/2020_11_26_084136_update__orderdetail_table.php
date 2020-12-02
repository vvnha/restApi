<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderdetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderDetails', function (Blueprint $table) {
            $table->foreign('orderID')
                    ->references('orderID')
                    ->on('orderTables')
                    ->onDelete('cascade');
            
        });
        Schema::table('orderDetails', function (Blueprint $table) {
            $table->foreign('foodID')
                    ->references('foodID')
                    ->on('foods')
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
