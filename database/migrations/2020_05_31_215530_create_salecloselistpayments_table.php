<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalecloselistpaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salecloselistpayments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('salecloselist_id');
            $table->datetime('paydate');
            $table->integer('user_id');
            $table->decimal('payamt');
            $table->text('note');
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
        Schema::dropIfExists('salecloselistpayments');
    }
}
