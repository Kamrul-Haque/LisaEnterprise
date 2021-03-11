<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_withdraws', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bank_account_id');
            $table->string('type');
            $table->string('cheque_no')->default('N/A');
            $table->string('date_of_issue');
            $table->string('status')->default('N/A');
            $table->string('date_of_draw')->nullable();
            $table->string('card_no')->default('N/A');
            $table->string('validity')->default('N/A');
            $table->string('cvv')->default('N/A');
            $table->decimal('amount',11,2)->unsigned();
            $table->string('entry_by');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_withdraws');
    }
}
