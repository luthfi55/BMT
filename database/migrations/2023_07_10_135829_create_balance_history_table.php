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
            $table->foreignId('operational_id')->nullable()->constrained('operational');    
            $table->foreignId('loan_bills_id')->nullable()->constrained('loan_bills');    
            $table->foreignId('savings_id')->nullable()->constrained('savings');    
            $table->integer('nominal');
            $table->string('description');
            $table->datetime('date');
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
