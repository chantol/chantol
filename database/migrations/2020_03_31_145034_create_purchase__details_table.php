<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->string('barcode');
            $table->integer('qty');
            $table->string('unit');
            $table->integer('qtycut');
            $table->integer('quantity');
            $table->decimal('unitprice',8,2);
            $table->float('discount');
            $table->decimal('amount',8,2);
            $table->integer('qtyunit');
            $table->boolean('submit');
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
        Schema::dropIfExists('purchase__details');
    }
}
