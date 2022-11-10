<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_terms', function (Blueprint $table) {
            $table->id();
            $table->integer('loan_id');
            $table->date('payment_date');
            $table->float('amount', 11, 2);
            $table->float('paid_amount', 11, 2)->nullable();
            $table->dateTime('paid_date')->nullable();
            $table->enum('status', ['Pending', 'Paid'])->default('Pending');
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
        Schema::dropIfExists('loan_terms');
    }
};
