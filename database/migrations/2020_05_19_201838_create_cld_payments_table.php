<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCldPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cld_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('closelist_delivery_id');
            $table->integer('userid');
            $table->datetime('paiddate');
            $table->decimal('paidamt',18,2);
            $table->text('desr');
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
        Schema::dropIfExists('cld_payments');
    }
}
