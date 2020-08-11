<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sale_id');
            $table->integer('product_id');
            $table->string('barcode');
            $table->integer('qty');
            $table->string('unit');
            $table->integer('qtycut');
            $table->integer('quantity');
            $table->decimal('unitprice',18,2);
            $table->float('discount');
            $table->decimal('amount',18,2);
            $table->string('cur');
            $table->integer('multiunit');
            $table->integer('qtyunit');
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
        Schema::dropIfExists('sale_details');
    }
}
