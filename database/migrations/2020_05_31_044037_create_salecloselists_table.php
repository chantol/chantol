<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalecloselistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salecloselists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('dd');
            $table->integer('user_id');
            $table->integer('supplier_id');
            $table->datetime('d1');
            $table->datetime('d2');
            $table->decimal('ivamount',18,2);
            $table->decimal('ivdeposit',18,2);
            $table->decimal('ivbalance',18,2);
            $table->decimal('oldlist',18,2);
            $table->decimal('total',18,2);
            $table->decimal('deposit',18,2);
            $table->decimal('balance',18,2);
            $table->string('cur');
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
        Schema::dropIfExists('salecloselists');
    }
}
