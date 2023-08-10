<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('type');
            $table->integer('nominal');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->enum('status', ['Active', 'Completed']);        
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
        Schema::dropIfExists('savings');
    }
}
