<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sl_no')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('godown_id');
            $table->unsignedBigInteger('supplier_id');
            $table->decimal('quantity',7,2)->unsigned();
            $table->string('unit');
            $table->decimal('buying_price',11,2)->unsigned();
            $table->decimal('paid',11,2)->unsigned();
            $table->decimal('due',11,2)->unsigned();
            $table->string('date');
            $table->string('entry_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('godown_id')->references('id')->on('godowns')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entries');
    }
}
