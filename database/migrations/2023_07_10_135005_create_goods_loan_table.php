<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsLoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_loan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');    
            $table->string('goods');        
            $table->integer('nominal');
            $table->integer('infaq');
            $table->string('infaq_type');
            $table->boolean('infaq_status');
            $table->integer('installment');
            $table->integer('installment_amount');
            $table->integer('month');
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
        Schema::dropIfExists('goods_loan');
    }
}
