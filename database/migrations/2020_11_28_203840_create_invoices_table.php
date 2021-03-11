<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sl_no')->nullable();
            $table->string('date');
            $table->unsignedBigInteger('client_id');
            $table->decimal('labour_cost',7,2)->unsigned();
            $table->decimal('transport_cost',7,2)->unsigned();
            $table->decimal('subtotal',11,2)->unsigned();
            $table->decimal('discount',7,2)->unsigned()->nullable();
            $table->decimal('tax',7,2)->unsigned()->nullable();
            $table->decimal('grand_total',11,2)->unsigned();
            $table->decimal('paid',11,2)->unsigned();
            $table->decimal('due',11,2)->unsigned();
            $table->unsignedBigInteger('payment_id');
            $table->string('sold_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('client_payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
