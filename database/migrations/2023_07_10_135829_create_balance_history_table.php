<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('balance_id')->constrained('balance');    
            $table->foreignId('operational_id')->constrained('operational');    
            $table->foreignId('loans_bills_id')->constrained('loan_bills');    
            $table->foreignId('savings_id')->constrained('savings');    
            $table->integer('nominal');
            $table->date('date');
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
        Schema::dropIfExists('balance_history');
    }
}
