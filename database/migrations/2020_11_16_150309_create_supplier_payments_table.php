<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sl_no')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->string('type');
            $table->decimal('amount',11,2)->unsigned();
            $table->string('date_of_issue');
            $table->string('account_no')->default('N/A');
            $table->string('cheque_no')->default('N/A');
            $table->string('date_of_draw')->nullable();
            $table->string('status')->default('N/A');
            $table->string('card_no')->default('N/A');
            $table->string('validity')->default('N/A');
            $table->string('cvv')->default('N/A');
            $table->string('received_by')->nullable();
            $table->boolean('product_purchase')->default(false);
            $table->softDeletes();
            $table->timestamps();

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
        Schema::dropIfExists('supplier_payments');
    }
}
