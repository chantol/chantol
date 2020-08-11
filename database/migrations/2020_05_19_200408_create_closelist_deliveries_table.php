<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCloselistDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closelist_deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('startdate');
            $table->datetime('enddate');
            $table->integer('userid');
            $table->integer('delivery_id');
            $table->decimal('olddebt',18,2);
            $table->decimal('total',18,2);
            $table->string('cur',10);
            $table->decimal('totalall',18,2);
            $table->decimal('deposit',18,2);
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
        Schema::dropIfExists('closelist_deliveries');
    }
}
