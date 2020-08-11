<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('supplier_id');
            $table->integer('delivery_id');
            $table->string('carnum')->nullable();
            $table->string('driver')->nullable();
            $table->text('invnote')->nullable();
            $table->decimal('subtotal',18,2);
            $table->float('discount');
            $table->decimal('total',18,2);
            $table->string('cur');
            $table->boolean('ispay')->default(0);
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
        Schema::dropIfExists('sales');
    }
}
