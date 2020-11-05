<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGodownProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('godown_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('godown_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('godown_quantity',11,2)->unsigned();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('godown_id')->references('id')->on('godowns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('godown_product');
    }
}
