<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sl_no')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('godown_from');
            $table->unsignedBigInteger('godown_to');
            $table->decimal('quantity',7,2)->unsigned();
            $table->string('date');
            $table->string('entry_by')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('godown_from')->references('id')->on('godowns');
            $table->foreign('godown_to')->references('id')->on('godowns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_transfers');
    }
}
