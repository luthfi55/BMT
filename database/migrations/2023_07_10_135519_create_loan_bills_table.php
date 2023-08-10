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
            $table->enum('type', ['Installment', 'Infaq']);
            $table->integer('installment_amount');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->enum('status', ['Overdue', 'Active', 'Completed']);
            $table->enum('payment_status', ['Overdue', 'Completed']);
            $table->string('payment_type')->nullable();
            $table->datetime('payment_date')->nullable();
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
