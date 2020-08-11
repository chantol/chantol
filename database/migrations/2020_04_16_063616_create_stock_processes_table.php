<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_processes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('startdate');
            $table->datetime('enddate');
            $table->integer('product_id');
            $table->tinyInteger('mode')->comment('0=closestock 1=add stock -1=sub stock');
            $table->integer('quantity');
            $table->decimal('amount',18,2);
            $table->boolean('active');
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
        Schema::dropIfExists('stock_processes');
    }
}
