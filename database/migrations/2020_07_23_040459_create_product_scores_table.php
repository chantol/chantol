<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->datetime('dd');
            $table->integer('product_id');
            $table->string('qtyset',100);
            $table->integer('qty');
            $table->decimal('price',18,2);
            $table->string('formonth',10);
            $table->string('foryear',10);
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
        Schema::dropIfExists('product_scores');
    }
}
