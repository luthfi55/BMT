<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_fund_id')->nullable()->constrained('loan_fund');
            $table->foreignId('goods_loan_id')->nullable()->constrained('goods_loan');
            $table->integer('month');
            $table->integer('installment');
            $table->integer('installment_amount');
            $table->datetime('date');
            $table->boolean('status');
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
        Schema::dropIfExists('loan_bills');
    }
}
